<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Metamagics;

use Shadowlab\Interfaces\Domain\Factory;

class MetamagicsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new MetamagicsEntity($data);
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
