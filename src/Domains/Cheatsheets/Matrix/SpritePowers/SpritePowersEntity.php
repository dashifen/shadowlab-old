<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\SpritePowers;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class SpritePowersEntity extends AbstractEntity
{
    protected $critter_power;
    protected $critter_power_id;
    protected $associated_test;
    protected $description;
    protected $duration;
    protected $action;
    protected $book_id;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
