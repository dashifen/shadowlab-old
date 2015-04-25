<?php

namespace Shadowlab\Domains\Cheatsheets\Gear;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class GearEntity extends AbstractEntity
{
    protected $gear;
    protected $gear_id;
    protected $gear_category_id;
    protected $description;
    protected $wireless_bonus;
    protected $availability;
    protected $legality;
    protected $cost;

    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    protected $attributes = [];

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}