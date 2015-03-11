<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\Programs;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class ProgramsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|ProgramsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $properties = ProgramsEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        $old_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $programs = $this->db->getResults($properties,
            "programs INNER JOIN books USING (book_id)",
            [], ["program"]);

        $this->db->setDatabase($old_db);
        return $programs;
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
