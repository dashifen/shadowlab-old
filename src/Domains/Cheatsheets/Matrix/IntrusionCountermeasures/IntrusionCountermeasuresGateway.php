<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class IntrusionCountermeasuresGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|IntrusionCountermeasuresEntity|bool
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
        // to get all of our intrusion countermeasures is to select the information from the database
        // that makes up our entity.

        $reflection = new \ReflectionClass(IntrusionCountermeasuresEntity::class);
        $properties = $reflection->getProperties();

        foreach($properties as &$property) $property = $property->getName();

        $original_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $actions = $this->db->getResults($properties, "ic INNER JOIN books USING (book_id)", [], ["ic"]);
        $this->db->setDatabase($original_db);

        return $actions;
    }

    protected function selectSome()
    {
        return false;
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
