<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CalledShotsLocations;

use Shadowlab\Interfaces\Domain\Factory;

class CalledShotsLocationsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new CalledShotsLocationsEntity($data);
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
