<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class MatrixActionsEntity extends AbstractEntity
{
    protected $matrix_action_id;
    protected $matrix_action;
    protected $matrix_action_type;
    protected $offensive_test;
    protected $defensive_test;
    protected $marks_required;
    protected $description;
    protected $reference;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
