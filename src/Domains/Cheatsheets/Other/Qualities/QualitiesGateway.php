<?php

namespace Shadowlab\Domains\Cheatsheets\Other\Qualities;

use Shadowlab\Exceptions\DatabaseException;
use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class QualitiesGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|QualitiesEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        // this is a harder query to write than most because we want to include both the "regular"
        // qualities and the qualities that "control" the adept ways.  the only way to do this is
        // with a UNION between the two tables and with some careful aliasing of the information
        // for the latter group.  this only works because we have no bindings to make within this
        // one.

        $qualities_query = <<<END_OF_QUERY

            SELECT quality_id, quality, description, max_rating, rated_cost, specific_cost,
                metagenetic, freakish, book_id, book, abbr, page, 0 AS is_way FROM qualities
                INNER JOIN books USING (book_id) WHERE parent_quality_id IS NULL

            UNION

            SELECT way_id AS quality_id, adept_way AS quality, description, 1 AS max_rating,
                IF(way_id=6, 15, 20) AS rated_cost, NULL AS specific_cost, 'N' AS metageneitc,
                'N' AS freakish, book_id, book, abbr, page, 1 AS is_way FROM adept_ways
                INNER JOIN books USING (book_id)

            ORDER BY quality

END_OF_QUERY;

        try {
            $old_db = $this->db->getDatabase();
            $this->db->setDatabase("dashifen_shadowlab");
            $qualities = $this->db->runQuery($qualities_query);
            $qualities = $qualities->fetch_all(MYSQL_ASSOC);

            // now that we have our information related to qualities, we need to find the
            // sub-qualities that they might have.  or, in the case of adept ways, the powers
            // that can be discounted when following that way.  to do so, we loop over our
            // list and we use both the is_way flag to find our information.

            foreach ($qualities as &$quality) {
                if ($quality["is_way"]) {

                    // ways have a list of powers that can be discounted in the adept_ways_powers
                    // table.  we'll want to select them here so that they can be displayed on-screen
                    // later.

                    $quality["powers"] = $this->db->getCol(
                        "DISTINCT adept_power",
                        "adept_powers INNER JOIN adept_ways_powers USING (adept_power_id)",
                        ["way_id" => $quality["quality_id"]],
                        ["adept_power"]
                    );
                } else {

                    // some qualities will have sub-qualities, e.g. the various levels of addiction
                    // or the various codes of honor, which we will look for here.

                    $quality["subqualities"] = $this->db->getResults(
                        ["IFNULL(rated_cost, specific_cost) AS cost, quality, description"],
                        "qualities",
                        ["parent_quality_id" => $quality["quality_id"]],
                        ["quality_id"]
                    );
                }
            }

            $this->db->setDatabase($old_db);
        } catch (DatabaseException $e) {
            var_dump($e->getMessage());
            var_dump($e->getQuery());
            exit;
        }

        return $qualities;
    }

    protected function selectSome(array $entities)
    {

    }

    public function insert(Entity $entity)
    {

    }

    public function update(Entity $entity)
    {

    }

    public function delete(Entity $entity)
    {

    }
}
