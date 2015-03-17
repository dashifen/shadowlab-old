<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits;

use Shadowlab\Interfaces\Domain\Factory;

class MentorSpiritsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new MentorSpiritsEntity($data);
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
