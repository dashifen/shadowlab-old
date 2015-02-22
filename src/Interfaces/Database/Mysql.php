<?php

namespace Shadowlab\Interfaces\Database;

interface Mysql
{
    public function upsert($table, array $values, array $updates = []);
    public function getEnumValues($table, $column);
}