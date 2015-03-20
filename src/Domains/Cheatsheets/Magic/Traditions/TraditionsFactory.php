<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Traditions;

use Shadowlab\Interfaces\Domain\Factory;

class TraditionsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new TraditionsEntity($data);
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
