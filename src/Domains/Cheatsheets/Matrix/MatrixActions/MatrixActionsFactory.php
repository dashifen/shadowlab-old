<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions;

use Shadowlab\Interfaces\Domain\Factory;

class MatrixActionsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new MatrixActionsEntity($data);
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
