<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures;

use Shadowlab\Interfaces\Domain\Factory;

class IntrusionCountermeasuresFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new IntrusionCountermeasuresEntity($data);
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
