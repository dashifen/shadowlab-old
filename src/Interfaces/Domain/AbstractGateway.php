<?php

namespace Shadowlab\Interfaces\Domain;

use Shadowlab\Interfaces\Database\AbstractMysqlDatabase;
use Shadowlab\Exceptions\DatabaseException;

abstract class AbstractGateway implements Gateway
{
    protected $db;

    /**
     * @param AbstractMysqlDatabase $db
     */
    public function __construct(AbstractMysqlDatabase $db)
    {
        $this->db = $db;
    }

    /**
     * @param $column
     * @return string
     */
    public function ticker(&$column)
    {
        $column = '`' . $column . '`';
        return $column;
    }

    /**
     * @param $column
     * @param null $table
     * @param array $criteria
     * @param array $orderby
     * @return mixed
     * @throws DatabaseException
     */
    public function getVar($column, $table = null, array $criteria = [], array $orderby = [])
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $var = $this->db->getVar(...func_get_args());
        $this->db->setDatabase($db);
        return $var;
    }

    /**
     * @param $column
     * @param $table
     * @param array $criteria
     * @param array $orderby
     * @return mixed
     * @throws DatabaseException
     */
    public function getCol($column, $table, array $criteria = [], array $orderby = [])
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $col = $this->db->getCol(...func_get_args());
        $this->db->setDatabase($db);
        return $col;
    }

    /**
     * @param array $columns
     * @param $table
     * @param array $criteria
     * @param array $orderby
     * @return mixed
     * @throws DatabaseException
     */
    public function getRow(array $columns, $table, array $criteria = [], array $orderby = [])
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $row = $this->db->getRow(...func_get_args());
        $this->db->setDatabase($db);
        return $row;
    }

    /**
     * @param array $columns
     * @param $table
     * @param array $criteria
     * @param array $orderby
     * @return mixed
     * @throws DatabaseException
     */
    public function getResults(array $columns, $table, array $criteria = [], array $orderby = [])
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $results = $this->db->getResults(...func_get_args());
        $this->db->setDatabase($db);
        return $results;
    }

    /**
     * @param array $columns
     * @param $table
     * @param array $criteria
     * @param array $orderby
     * @return mixed
     * @throws DatabaseException
     */
    public function getMap(array $columns, $table, array $criteria = [], array $orderby = [])
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $map = $this->db->getMap(...func_get_args());
        $this->db->setDatabase($db);
        return $map;
    }

    /**
     * @param $table
     * @param $column
     * @return mixed
     * @throws DatabaseException
     */
    public function getEnumValues($table, $column)
    {
        $db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $values = $this->db->getEnumValues($table, $column);
        $this->db->setDatabase($db);
        return $values;
    }

    /**
     * @return null|string
     */
    public function getError()
    {
        return $this->db->getError();
    }

    abstract public function select(array $entities = null);
    abstract public function insert(Entity $entity);
    abstract public function update(Entity $entity);
    abstract public function delete(Entity $entity);
}