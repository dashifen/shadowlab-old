<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\MartialArts;

use Shadowlab\Interfaces\Domain\Factory;

class MartialArtsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new MartialArtsEntity($data);
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
