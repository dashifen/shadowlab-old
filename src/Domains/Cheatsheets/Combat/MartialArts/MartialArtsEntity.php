<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\MartialArts;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class MartialArtsEntity extends AbstractEntity
{
    protected $style;
    protected $style_id;
    protected $description;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    protected $techniques = [];
    protected $skill_group;
    protected $skill;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
