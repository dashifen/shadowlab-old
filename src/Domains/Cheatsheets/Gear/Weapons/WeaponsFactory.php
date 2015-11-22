<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\Weapons;

use Shadowlab\Interfaces\Domain\Factory;

class WeaponsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new WeaponsEntity($data);
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
