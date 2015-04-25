<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CalledShots;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class CalledShotsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|CalledShotsEntity|bool
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
        $properties = CalledShotsEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        $shots = $this->db->getResults($properties,
            "called_shots INNER JOIN books USING (book_id)",
            [], ["called_shot"]);

        $this->db->setDatabase($original_db);
        return $shots;
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
