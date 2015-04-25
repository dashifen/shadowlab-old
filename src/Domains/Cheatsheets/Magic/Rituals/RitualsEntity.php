<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Rituals;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class RitualsEntity extends AbstractEntity
{
    protected $ritual;
    protected $ritual_id;
    protected $description;
    protected $prerequisite_metamagic_id;
    protected $prerequisite_metamagic_school_id;
    protected $prerequisite_ritual_id;
    protected $length;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    protected $ritual_tags = [];

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
