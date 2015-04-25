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

    public function ticker(&$column)
    {
        $column = '`' . $column . '`';
        return $column;
    }

    public function getVar($column, $table = null, array $criteria = [], array $orderby = [])
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $var = $this->db->getVar(...func_get_args());
        $this->db->setDatabase($db);
        return $var;
    }

    public function getCol($column, $table, array $criteria = [], array $orderby = [])
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $col = $this->db->getCol(...func_get_args());
        $this->db->setDatabase($db);
        return $col;
    }

    public function getRow(array $columns, $table, array $criteria = [], array $orderby = [])
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $row = $this->db->getRow(...func_get_args());
        $this->db->setDatabase($db);
        return $row;
    }

    public function getResults(array $columns, $table, array $criteria = [], array $orderby = [])
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $results = $this->db->getResults(...func_get_args());
        $this->db->setDatabase($db);
        return $results;
    }

    public function getMap(array $columns, $table, array $criteria = [], array $orderby = [])
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $map = $this->db->getMap(...func_get_args());
        $this->db->setDatabase($db);
        return $map;
    }

    public function getEnumValues($table, $column)
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $values = $this->db->getEnumValues($table, $column);
        $this->db->setDatabase($db);
        return $values;
    }

    abstract public function select(array $entities = null);
    abstract public function insert(Entity $entity);
    abstract public function update(Entity $entity);
    abstract public function delete(Entity $entity);
}