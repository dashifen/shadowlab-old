<?php

namespace Shadowlab\Interfaces\Domain;

interface Factory
{
    public function newEntity(array $row);
    public function newCollection(array $rows);
}