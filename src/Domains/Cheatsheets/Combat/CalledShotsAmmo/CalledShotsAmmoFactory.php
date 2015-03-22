<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CalledShotsAmmo;

use Shadowlab\Interfaces\Domain\Factory;

class CalledShotsAmmoFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new CalledShotsAmmoEntity($data);
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
