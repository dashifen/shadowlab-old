<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Spells;

use Shadowlab\Interfaces\Domain\Factory;

class SpellsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new SpellsEntity($data);
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
