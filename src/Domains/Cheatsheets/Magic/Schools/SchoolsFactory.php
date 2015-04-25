<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Schools;

use Shadowlab\Interfaces\Domain\Factory;

class SchoolsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new SchoolsEntity($data);
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
