<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Spirits;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class SpiritsEntity extends AbstractEntity
{
    // spirits are stored in the critters table and the following properties are all
    // stored/found therein except for the last four which are in the books table.

    protected $critter;
    protected $critter_id;
    protected $weaknesses;
    protected $description;
    protected $other_notes;
    protected $physical_init;
    protected $astral_init;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    // but, critters also have attributes, skills, and powers so we'll need to prepare
    // properties where those data can be stored as well.

    protected $opt_powers = [];
    protected $attributes = [];
    protected $skills = [];
    protected $powers = [];
				
				// finally, spirits are also a part of specific traditions, so we'll need to
				// have a property availbale to store those data.
				
				protected $traditions = [];

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
