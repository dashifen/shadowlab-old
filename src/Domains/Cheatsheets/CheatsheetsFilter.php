<?php

namespace Shadowlab\Domains\Cheatsheets;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\AbstractFilter;
use Shadowlab\Interfaces\Domain\Entity;

class CheatsheetsFilter extends AbstractFilter
{
    public function setEntity(Entity $entity)
    {
        if(!($entity instanceof CheatsheetsEntity)) {
            throw new EntityException("Unexpected Entity:  " . get_class($entity));
        }

        $this->entity = $entity;
    }

    public function filterSelect() { }
    public function filterInsert() { }
    public function filterUpdate() { }
    public function filterDelete() { }
    public function validate() { }
}