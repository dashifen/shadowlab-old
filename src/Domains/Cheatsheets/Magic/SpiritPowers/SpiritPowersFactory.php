<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\SpiritPowers;

use Shadowlab\Interfaces\Domain\Factory;

class SpiritPowersFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new SpiritPowersEntity($data);
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
