<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase;

use Shadowlab\Interfaces\Domain\Factory;

class SpriteDatabaseFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new SpriteDatabaseEntity($data);
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
