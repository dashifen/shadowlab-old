<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class ComplexFormsEntity extends AbstractEntity
{

    protected $complex_form;
    protected $complex_form_id;
    protected $description;
    protected $duration;
    protected $target;
    protected $fading;
    protected $book_id;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
