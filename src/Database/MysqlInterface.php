<?php

namespace Shadowlab\Database;

interface MysqlInterface
{
    public function upsert($table, array $values, array $updates = []);
}