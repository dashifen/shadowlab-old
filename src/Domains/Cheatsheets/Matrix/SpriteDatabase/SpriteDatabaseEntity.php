<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class SpriteDatabaseEntity extends AbstractEntity
{
    // sprites are listed as critters in the database.  these initial properties
    // are all located in that table.  currently, sprites don't have weaknesses,
    // strengths, other_notes, etc. so we don't even worry about those columns.

    protected $critter;
    protected $critter_id;
    protected $description;
    protected $matrix_init;
    protected $book_id;
    protected $page;
    protected $abbr;

    // now for the harder parts.  we'll want to get sprite attributes, skills, and
    // powers.  these are actually arrays of data from the database that we need
    // to collect in order to set.

    protected $attributes = [];
    protected $skills = [];
    protected $powers = [];

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
