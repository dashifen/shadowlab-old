<?php

namespace Shadowlab\Responses\Cheatsheets\Combat;

use Shadowlab\Interfaces\Response\AbstractResponse;

class CombatActions extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this page is rather complex.  there are two select elements for which we
        // have to find our options here.  the first is a record of the action types (e.g. free, complex, 
        // etc.) while the second deals with the type of combat.

        $action_types = [];
        $combat_types = [];
        $actions = $this->payload->getPayload("actions");
        foreach ($actions as $action) {
            $action_type = $action["action_type"];
            $combat_type = $action["combat_type"];

            if (!isset($action_types[$action_type])) {
                $action_types[$action_type] = 1;
            }

            if (!isset($combat_types[$combat_type])) {
                $combat_types[$combat_type] = 1;
            }
        }

        $action_types = array_keys($action_types);
        $combat_types = array_keys($combat_types);
        sort($action_types);
        sort($combat_types);

        $this->setView('Cheatsheets\Combat\CombatActions', [
            "title"        => "Combat Actions",
            "action_types" => $action_types,
            "combat_types" => $combat_types,
            "actions"      => $actions,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Combat\CombatActions', [
            "title"        => "Combat Actions Not Found",
            "action_types" => [],
            "combat_types" => [],
            "actions"      => [],
        ]);
    }
}