<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Enchantments;

use Shadowlab\Interfaces\Domain\Factory;

class EnchantmentsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new EnchantmentsEntity($data);
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
