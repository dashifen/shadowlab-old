<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms;

use Shadowlab\Interfaces\Domain\Factory;

class ComplexFormsFactory implements Factory
{
    public function newEntity(array $data)
    {
        return new ComplexFormsEntity($data);
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
