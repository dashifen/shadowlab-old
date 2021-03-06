<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class AdeptPowersGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|AdeptPowersEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $original_db = $this->db->getDatabase();
        $properties = AdeptPowersEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        $this->db->setDatabase("dashifen_shadowlab");

        $powers = $this->db->getResults($properties,
            "adept_powers INNER JOIN books USING (book_id)",
            [], ["adept_power"]);

        $this->db->setDatabase($original_db);
        return $powers;
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
