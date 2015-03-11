<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Spells;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class SpellsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|SpellsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        // if our $entries argument is null, then we want to select all of the spells in the database
        // for display as a full cheatsheet.  otherwise, we use $entries to select some of our spells,
        // usually just one, for editing.

        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    public function selectAll()
    {
        $properties = SpellsEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        $original_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $spells = $this->db->getResults($properties, "spells_view", [], ["spell"]);
        $this->db->setDatabase($original_db);

        return $spells;
    }

    public function selectSome(array $entities)
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
