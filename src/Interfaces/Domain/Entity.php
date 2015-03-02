<?php

namespace Shadowlab\Interfaces\Domain;

interface Entity
{
    public function getAll();
    public function get($key);
    public function set($key, $value);
    public function getAllExcept(array $except);
    public function setAll(array $data);
}