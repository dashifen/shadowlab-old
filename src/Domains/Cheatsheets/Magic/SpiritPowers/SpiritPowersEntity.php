<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\SpiritPowers;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class SpiritPowersEntity extends AbstractEntity
{
    protected $critter_power_id;
    protected $critter_power;
    protected $description;
    protected $associated_test;
    protected $type;
    protected $action;
    protected $range;
    protected $duration;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
