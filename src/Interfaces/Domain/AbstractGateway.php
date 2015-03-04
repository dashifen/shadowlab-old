<?php

namespace Shadowlab\Interfaces\Domain;

use Shadowlab\Interfaces\Database\AbstractMysqlDatabase;

abstract class AbstractGateway implements Gateway
{
    protected $db;

    public function __construct(AbstractMysqlDatabase $db)
    {
        $this->db = $db;
    }

    abstract public function select(array $entities = null);
    abstract public function insert(Entity $entity);
    abstract public function update(Entity $entity);
    abstract public function delete(Entity $entity);
}