<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Rituals;

use Shadowlab\Interfaces\Domain\Factory;

class RitualsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new RitualsEntity($data);
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
