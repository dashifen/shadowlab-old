<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CalledShots;

use Shadowlab\Interfaces\Domain\Factory;

class CalledShotsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new CalledShotsEntity($data);
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
