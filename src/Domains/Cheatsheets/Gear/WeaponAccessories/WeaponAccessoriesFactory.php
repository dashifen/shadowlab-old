<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\WeaponAccessories;

use Shadowlab\Interfaces\Domain\Factory;

class WeaponAccessoriesFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new WeaponAccessoriesEntity($data);
    }

    public function newCollection(array $data)
    {
        $collection = [];
        foreach($data as $datum) {
            $collection[] = $this->newEntity($datum);
        }

        return $collection;
    }
}
