<?php

namespace Shadowlab\Interfaces\Database;

use Shadowlab\Exceptions\DatabaseException;

/**
 * Class AbstractMysqlDatabase
 * @package Shadowlab\Interfaces\Databases
 */
abstract class AbstractMysqlDatabase implements Database, Mysql
{
    /**
     * @var \mysqli $db
     */
    protected $db;

    /**
     * The default value of this property should match the one in config.php.
     * @var string $database
     */
    protected $database = 'dashifen_slapp';     // slapp == shadowlab app

    /**
     * @var bool
     */
    protected $distinct = false;

    /**
     * @param \mysqli $db
     */
    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

    public function __destruct()
    {
        $this->db->close();
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param $database
     * @return bool
     * @throws DatabaseException
     */
    public function setDatabase($database)
    {
        $success = $this->db->select_db($database);
        if(!$success) throw new DatabaseException("Unable to use database: {$database}");
        $this->database = $database;
        return true;
    }

    /**
     * @return int
     */
    public function getAffectedRows()
    {
        return $this->db->affected_rows;
    }

    /**
     * @return mixed
     */
    public function getInsertedId()
    {
        return $this->db->insert_id;
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return !empty($this->database);
    }

    public function setDistinct($distinct)
    {
        $distinct = $distinct ? true : false;
        $this->distinct = $distinct;
    }

    abstract public function runQuery($query);
    abstract public function getVar($column, $table = null, array $criteria = [], array $orderby = []);
    abstract public function getCol($column, $table, array $criteria = [], array $orderby = []);
    abstract public function getRow(array $columns, $table, array $criteria = [], array $orderby = []);
    abstract public function getResults(array $columns, $table, array $criteria = [], array $orderby = []);
    abstract public function getMap(array $columns, $table, array $criteria = [], array $orderby = []);
    abstract public function insert($table, array $values);
    abstract public function update($table, array $values, array $criteria = []);
    abstract public function delete($table, array $criteria = [], $limit = null, $offset = null);
    abstract public function upsert($table, array $values, array $updates = []);
    abstract public function getEnumValues($table, $column);
    abstract public function getColumns($table);
}

