<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Schools;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class SchoolsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|SchoolsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        // this is a harder query to write than most because we want to include both the "regular"
        // schools and the adept ways.  the best way to do this is with a UNION between the two tables
        // and with some careful aliasing of the information for the latter group.

        $schools_query = <<<END_OF_QUERY

            SELECT school_id, school_name, school_type, description, book_id, book, abbr, page
                FROM metamagics_schools INNER JOIN books USING (book_id)

            UNION

            SELECT way_id AS school_id, adept_way AS school_name, 'Physical Arts' AS school_type,
                description, book_id, book, abbr, page FROM adept_ways INNER JOIN books USING (book_id)

            ORDER BY school_name

END_OF_QUERY;

        $original_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $schools = $this->db->runQuery($schools_query);
        $schools = $schools->fetch_all(MYSQL_ASSOC);

        foreach ($schools as &$school) {
            if ($school["school_type"] != "Physical Arts") {
                $school["powers"] = [];

                // magical schools, as opposed to adept ways, have enchantments, metamagics, and rituals
                // that we'll select now.

                $school["enchantments"] = $this->db->getResults(
                    ["enchantment", "`primary`"],
                     "metamagics_schools_enchantments INNER JOIN enchantments USING (enchantment_id)",
                    ["school_id" => $school["school_id"]],
                    ["enchantment"]
                );

                $school["metamagics"] = $this->db->getResults(
                    ["metamagic", "`primary`"],
                     "metamagics_schools_metamagics INNER JOIN metamagics USING (metamagic_id)",
                    ["school_id" => $school["school_id"]],
                    ["metamagic"]
                );

                $school["rituals"] = $this->db->getResults(
                    ["ritual", "`primary`"],
                     "metamagics_schools_rituals INNER JOIN rituals USING (ritual_id)",
                    ["school_id" => $school["school_id"]],
                    ["ritual"]
                );
            } else {
                $school["enchantments"] = [];

                // adept ways have metamagics, rituals, and adept powers.  like above, we'll select them
                // here.

                $school["metamagics"] = $this->db->getCol("metamagic",
                     "adept_ways_metamagics INNER JOIN metamagics USING (metamagic_id)",
                    ["way_id" => $school["school_id"]],
                    ["metamagic"]
                );

                $school["powers"] = $this->db->getCol("adept_power",
                     "adept_ways_powers INNER JOIN adept_powers USING (adept_power_id)",
                    ["way_id" => $school["school_id"]],
                    ["adept_power"]
                );

                $school["rituals"] = $this->db->getCol("ritual",
                     "adept_ways_rituals INNER JOIN rituals USING (ritual_id)",
                    ["way_id" => $school["school_id"]],
                    ["ritual"]
                );
            }
        }

        $this->db->setDatabase($original_db);
        return $schools;
    }

    protected function selectSome(array $entities)
    {
        return [];
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
