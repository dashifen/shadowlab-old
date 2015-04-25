<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Enchantments;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class EnchantmentsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|EnchantmentsEntity|bool
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
        $properties = EnchantmentsEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        $enchantments = $this->db->getResults($properties, "enchantments INNER JOIN books USING (book_id)", [], ["enchantment"]);

        foreach ($enchantments as &$enchantment) {
            $enchantment["prerequisite_metamagic"] = is_numeric($enchantment["prerequisite_metamagic_id"])
                ? $this->db->getVar("metamagic", "metamagics", ["metamagic_id" => $enchantment["prerequisite_metamagic_id"]])
                : "";

            $enchantment["prerequisite_metamagic_school"] = is_numeric($enchantment["prerequisite_metamagic_school_id"])
                ? $this->db->getVar("school_name", "metamagics_schools", ["school_id" => $enchantment["prerequisite_metamagic_school_id"]])
                : "";
        }

        $this->db->setDatabase($original_db);
        return $enchantments;
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
