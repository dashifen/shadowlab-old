<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Enchantments;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class EnchantmentsEntity extends AbstractEntity
{
    protected $enchantment;
    protected $enchantment_id;
    protected $prerequisite_metamagic_id;
    protected $prerequisite_metamagic_school_id;
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
