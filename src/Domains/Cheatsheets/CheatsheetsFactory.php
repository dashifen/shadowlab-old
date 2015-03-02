<?php

namespace Shadowlab\Domains\Cheatsheets;

use Shadowlab\Interfaces\Domain\Factory;

class CheatsheetsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new CheatsheetsEntity($data);
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
