<?php

namespace Shadowlab\Interfaces\Database;

interface MysqlInterface
{
    public function upsert($table, array $values, array $updates = []);
    public function getEnumValues($table, $column);
}