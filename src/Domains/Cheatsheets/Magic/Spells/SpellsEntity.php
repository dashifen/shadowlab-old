<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Spells;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class SpellsEntity extends AbstractEntity
{
    protected $spell_id;
    protected $spell_category_id;
    protected $spell;
    protected $spell_category;
    protected $description;
    protected $spell_tags;
    protected $spell_tags_ids;
    protected $type;
    protected $range;
    protected $damage;
    protected $duration;
    protected $drain;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
