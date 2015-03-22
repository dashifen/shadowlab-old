<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\MartialArtsTechniques;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class MartialArtsTechniquesEntity extends AbstractEntity
{
    protected $technique;
    protected $technique_id;
    protected $description;

    // some of our techniques are maintained in other database tables.  when this is the case, we
    // need to know information about that table as follows.

    protected $table;
    protected $primary_key;
    protected $primary_key_value;

    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    protected $styles = [];

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
