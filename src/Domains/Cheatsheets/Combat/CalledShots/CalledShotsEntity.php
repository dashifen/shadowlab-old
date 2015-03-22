<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CalledShots;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class CalledShotsEntity extends AbstractEntity
{
    protected $called_shot;
    protected $called_shot_id;
    protected $description;
    protected $limitation;
    protected $requires_training;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
