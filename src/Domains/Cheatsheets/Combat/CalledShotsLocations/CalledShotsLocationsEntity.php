<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CalledShotsLocations;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class CalledShotsLocationsEntity extends AbstractEntity
{
    protected $location_id;
    protected $location;
    protected $location_type;
    protected $modifier;
    protected $max_dv;
    protected $effect;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
