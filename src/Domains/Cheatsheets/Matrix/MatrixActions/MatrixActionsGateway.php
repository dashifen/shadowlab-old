<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class MatrixActionsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|MatrixActionsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        // when our $entities argument is null, we want to return the entire list of matrix actions
        // to be turned into entities and used to display our cheatsheet on-screen.  when it's not null
        // we'll the appropriate information from the database based on that which has been passed to
        // us.

        return $entities === null ? $this->selectAll() : $this->selectSome();
    }

    protected function selectAll()
    {
        // to get all of our matrix actions is to select the information from the database that makes
        // up our entity.  for the moment, we've prepared a view in the database to make this selection
        // as easy as possible, but we'll need to break that up later to be sure that we can insert new
        // actions.

        $reflection = new \ReflectionClass(MatrixActionsEntity::class);
        $properties = $reflection->getProperties();
        foreach($properties as &$property) $property = $property->getName();

        $original_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $actions = $this->db->getResults($properties, "matrix_actions_view", [], ["matrix_action"]);
        $this->db->setDatabase($original_db);

        return $actions;
    }

    protected function selectSome()
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
