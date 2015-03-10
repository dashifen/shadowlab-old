<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class IntrusionCountermeasuresEntity extends AbstractEntity
{
    protected $ic;
    protected $ic_id;
    protected $description;
    protected $associated_test;
    protected $purpose;
    protected $book_id;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
