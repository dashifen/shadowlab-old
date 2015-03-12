<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\AbstractFilter;
use Shadowlab\Interfaces\Domain\Entity;

class SpriteDatabaseFilter extends AbstractFilter
{
    public function setEntity(Entity $entity)
    {
        if(!($entity instanceof SpriteDatabaseEntity)) {
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