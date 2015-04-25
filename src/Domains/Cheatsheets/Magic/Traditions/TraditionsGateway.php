<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Traditions;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class TraditionsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|TraditionsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $original_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $properties = TraditionsEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        // for display purposes, there's two more things we want to select for the screen:  the
        // corresponding name of the drain and alternate drain attributes.  we'll specify how to
        // select them by adding that information to $properties.  then, we'll join the attributes
        // table into the query below.

        $properties[] = "fnGet_ucfirst(drain.attribute) AS drain_attribute";
        $properties[] = "fnGet_ucfirst(alt_drain.attribute) AS alt_attr";

        $tables = "traditions INNER JOIN books USING (book_id) "
            . "INNER JOIN attributes AS drain ON drain.attribute_id = drain_attribute_id "
            . "LEFT JOIN attributes AS alt_drain ON alt_drain.attribute_id = alt_drain_attr_id";

        // joining in those two tables means that we've created an ambiguity related to the "abbr"
        // column.  we'll look for it in our $properties and then make sure we select the on from
        // the books table.

        foreach ($properties as &$property) {
            if ($property == "`abbr`") {
                $property = "`books`.`abbr`";
                break;
            }
        }

        $traditions = $this->db->getResults($properties, $tables, [], ["tradition"]);

        foreach ($traditions as &$tradition) {
            $tradition_id = $tradition["tradition_id"];

            // for each tradition we want to also select its preferred spells and adept powers as
            // well as the spirits that are summoned by conjurers within it.

            $tradition["spirits"] = $this->db->getMap(
                ["spell_category", "critter"],
                "traditions_spirits INNER JOIN spells_categories USING (spell_category_id) INNER JOIN critters USING (critter_id)",
                ["tradition_id" => $tradition_id],
                ["spell_category"]
            );

            $tradition["powers"] = $this->db->getCol(
                "adept_power",
                "traditions_adept_powers INNER JOIN adept_powers USING (adept_power_id)",
                ["tradition_id" => $tradition_id],
                ["adept_power"]
            );

            $tradition["spells"] = $this->db->getCol(
                "spell",
                "traditions_spells INNER JOIN spells USING (spell_id)",
                ["tradition_id" => $tradition_id],
                ["spell"]
            );
        }

        $this->db->setDatabase($original_db);
        return $traditions;
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
