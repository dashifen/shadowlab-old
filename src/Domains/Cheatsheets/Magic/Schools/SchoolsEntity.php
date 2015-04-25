<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Schools;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class SchoolsEntity extends AbstractEntity
{
    protected $school_id;
    protected $school_name;
    protected $school_type;
    protected $description;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    protected $enchantments;
    protected $metamagics;
    protected $rituals;
    protected $powers;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
