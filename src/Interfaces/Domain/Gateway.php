<?php

namespace Shadowlab\Interfaces\Domain;

interface Gateway
{
    public function ticker(&$column);
    public function select(array $entities = null);
    public function insert(Entity $entity);
    public function update(Entity $entity);
    public function delete(Entity $entity);

    public function getVar($column, $table = null, array $criteria = [], array $orderby = []);
    public function getCol($column, $table, array $criteria = [], array $orderby = []);
    public function getRow(array $columns, $table, array $criteria = [], array $orderby = []);
    public function getResults(array $columns, $table, array $criteria = [], array $orderby = []);
    public function getMap(array $columns, $table, array $criteria = [], array $orderby = []);
    public function getEnumValues($table, $column);
}
