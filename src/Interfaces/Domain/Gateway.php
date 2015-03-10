<?php

namespace Shadowlab\Interfaces\Domain;

interface Gateway
{
    public function ticker(&$column);
    public function select(array $entities = null);
    public function insert(Entity $entity);
    public function update(Entity $entity);
    public function delete(Entity $entity);
}
