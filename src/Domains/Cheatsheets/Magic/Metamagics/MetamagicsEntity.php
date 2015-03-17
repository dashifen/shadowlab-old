<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Metamagics;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class MetamagicsEntity extends AbstractEntity
{
    protected $metamagic_id;
    protected $metamagic;
    protected $description;
    protected $adept_only;
    protected $repeatable;
    protected $associated_test;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
