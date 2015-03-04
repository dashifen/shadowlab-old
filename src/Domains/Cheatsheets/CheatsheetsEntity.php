<?php

namespace Shadowlab\Domains\Cheatsheets;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class CheatsheetsEntity extends AbstractEntity
{
    protected $cheatsheet_type;
    protected $cheatsheet_name;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
