<?php

namespace Shadowlab\Domains\User;

use Shadowlab\Interfaces\Domain\Factory;

class UserFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new UserEntity($data);
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
