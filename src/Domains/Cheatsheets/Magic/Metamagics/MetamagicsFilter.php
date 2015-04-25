<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Metamagics;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\AbstractFilter;
use Shadowlab\Interfaces\Domain\Domain;use Shadowlab\Interfaces\Domain\Entity;

class MetamagicsFilter extends AbstractFilter
{
    public function setEntity(Entity $entity)
    {
        if(!($entity instanceof MetamagicsEntity)) {
            throw new EntityException("Unexpected Entity:  " . get_class($entity));
        }

        $this->entity = $entity;
    }

    protected function setDomain(Domain $domain) { }

    public function filterSelect() { }
    public function filterInsert() { }
    public function filterUpdate() { }
    public function filterDelete() { }
    public function validate(Entity $entity, Domain $domain, $action = "insert") { }
}