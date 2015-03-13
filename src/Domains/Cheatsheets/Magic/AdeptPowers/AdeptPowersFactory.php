<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers;

use Shadowlab\Interfaces\Domain\Factory;

class AdeptPowersFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new AdeptPowersEntity($data);
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
