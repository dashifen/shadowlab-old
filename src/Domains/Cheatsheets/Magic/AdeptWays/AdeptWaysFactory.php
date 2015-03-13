<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\AdeptWays;

use Shadowlab\Interfaces\Domain\Factory;

class AdeptWaysFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new AdeptWaysEntity($data);
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
