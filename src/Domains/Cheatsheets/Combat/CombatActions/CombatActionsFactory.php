<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CombatActions;

use Shadowlab\Interfaces\Domain\Factory;

class CombatActionsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new CombatActionsEntity($data);
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
