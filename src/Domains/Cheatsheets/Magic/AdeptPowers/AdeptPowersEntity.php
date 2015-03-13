<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class AdeptPowersEntity extends AbstractEntity
{
    protected $adept_power;
    protected $adept_power_id;
    protected $description;
    protected $activation;
    protected $levels;
    protected $cost;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
