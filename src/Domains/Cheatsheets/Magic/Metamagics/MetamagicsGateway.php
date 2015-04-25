<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Metamagics;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class MetamagicsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|MetamagicsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $original_db = $this->db->getDatabase();
        $properties = MetamagicsEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        $this->db->setDatabase("dashifen_shadowlab");

        $metamagics = $this->db->getResults($properties,
            "metamagics INNER JOIN books USING (book_id)",
            [], ["metamagic"]);

        $this->db->setDatabase($original_db);
        return $metamagics;
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
