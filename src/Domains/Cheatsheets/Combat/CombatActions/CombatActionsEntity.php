<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CombatActions;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class CombatActionsEntity extends AbstractEntity
{
    protected $action;
    protected $action_id;
    protected $action_type;
    protected $combat_type;
    protected $martial_art;
    protected $initiative_modifier;
    protected $active_defense;
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
