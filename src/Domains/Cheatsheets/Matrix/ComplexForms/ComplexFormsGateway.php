<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class ComplexFormsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|ComplexFormsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $reflection = new \ReflectionClass(ComplexFormsEntity::class);
        $properties = $reflection->getProperties();
        foreach($properties as &$property) $property = $property->getName();
        array_walk($properties, [$this, "ticker"]);

        $old_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $forms = $this->db->getResults($properties,
            "complex_forms INNER JOIN books USING (book_id)",
            [], ["complex_form"]);

        $this->db->setDatabase($old_db);

        return $forms;
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
