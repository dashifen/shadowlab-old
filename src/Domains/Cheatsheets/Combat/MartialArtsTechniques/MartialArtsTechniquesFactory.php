<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\MartialArtsTechniques;

use Shadowlab\Interfaces\Domain\Factory;

class MartialArtsTechniquesFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new MartialArtsTechniquesEntity($data);
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
