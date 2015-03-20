<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Traditions;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class TraditionsEntity extends AbstractEntity
{
    protected $tradition;
    protected $tradition_id;
    protected $description;
    protected $drain_attribute_id;
    protected $alt_drain_attr_id;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
