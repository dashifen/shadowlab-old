<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\Weapons;

use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Exceptions\EntityException;
use Shadowlab\Domains\Cheatsheets\Gear\GearGateway;

class WeaponsGateway extends GearGateway
{
    public function select(array $entities = null)
    {
        return $entities == null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        return [];
    }

    protected function selectSome(array $entities)
    {
        return [];
    }

    protected function confirmEntity(Entity $entity)
    {
        if (!($entity instanceof WeaponsEntity)) {
            throw new EntityException("Unexpected entity:  " . get_class($entity));
        }

        return true;
    }
}
