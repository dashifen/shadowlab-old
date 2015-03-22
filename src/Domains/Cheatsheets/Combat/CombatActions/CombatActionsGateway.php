<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CombatActions;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class CombatActionsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|CombatActionsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    public function selectAll()
    {
        $original_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $properties = CombatActionsEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        $actions = $this->db->getResults($properties,
            "combat_actions INNER JOIN books USING (book_id)",
            [], ["action"]);

        $this->db->setDatabase($original_db);
        return $actions;
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
