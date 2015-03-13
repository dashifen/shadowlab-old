<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\AdeptWays;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class AdeptWaysEntity extends AbstractEntity
{
    protected $way_id;
    protected $adept_way;
    protected $description;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
