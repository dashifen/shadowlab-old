<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Spirits;

use Shadowlab\Interfaces\Domain\Factory;

class SpiritsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new SpiritsEntity($data);
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
