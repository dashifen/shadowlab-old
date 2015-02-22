<?php

namespace Shadowlab\Interfaces\Database;

interface Database
{
    public function isConnected();
    public function getDatabase();
    public function setDatabase($database);
    public function getColumns($table);
    public function getAffectedRows();
    public function getInsertedId();

    public function runQuery($query);

    public function getVar($column, $table = null, array $criteria = [], array $orderby = []);
    public function getCol($column, $table, array $criteria = [], array $orderby = []);
    public function getRow(array $columns, $table, array $criteria = [], array $orderby = []);
    public function getResults(array $columns, $table, array $criteria = [], array $orderby = []);

    public function insert($table, array $values);
    public function update($table, array $values, array $criteria = []);
    public function delete($table, array $criteria = [], $limit = null, $offset = null);
}
