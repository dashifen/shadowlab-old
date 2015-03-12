<?php

namespace Shadowlab\Domains\Cheatsheets\Other\Qualities;

use Shadowlab\Interfaces\Domain\Factory;

class QualitiesFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new QualitiesEntity($data);
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
