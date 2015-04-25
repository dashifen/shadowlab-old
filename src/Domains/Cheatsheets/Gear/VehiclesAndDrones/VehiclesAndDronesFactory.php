<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\VehiclesAndDrones;

use Shadowlab\Interfaces\Domain\Factory;

class VehiclesAndDronesFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new VehiclesAndDronesEntity($data);
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
