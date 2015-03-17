<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class MentorSpiritsEntity extends AbstractEntity
{
    protected $mentor_spirit_id;
    protected $mentor_spirit;
    protected $description;
    protected $adv_all;
    protected $adv_magician;
    protected $adv_adept;
    protected $disadvantages;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
