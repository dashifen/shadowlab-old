<?php

namespace Shadowlab\Interfaces\Domain;

interface Entity
{
    public function get($key);
    public function getAll();
    public function getAllExcept(array $except);

    public function set($key, $value);
    public function setArray($key, array $value = []);
    public function setArrayIndex($key, $index, $value);
    public function setAll(array $data);

    public static function getProperties();
}
