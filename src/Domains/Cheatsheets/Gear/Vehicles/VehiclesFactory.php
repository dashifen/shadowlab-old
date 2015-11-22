<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\Vehicles;

use Shadowlab\Interfaces\Domain\Factory;

class VehiclesFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new VehiclesEntity($data);
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
