<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\Programs;

use Shadowlab\Interfaces\Domain\Factory;

class ProgramsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new ProgramsEntity($data);
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
