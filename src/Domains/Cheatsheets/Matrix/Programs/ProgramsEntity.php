<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\Programs;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class ProgramsEntity extends AbstractEntity
{
    protected $program;
    protected $program_id;
    protected $program_type;
    protected $description;
    protected $book_id;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
