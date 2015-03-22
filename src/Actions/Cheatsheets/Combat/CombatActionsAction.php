<?php

namespace Shadowlab\Actions\Cheatsheets\Combat;

use Shadowlab\Interfaces\Action\AbstractAction;

class CombatActionsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Combat\CombatActions\CombatActions
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Combat\CombatActions
     */
    protected $http;

    public function execute()
    {
        $data = $this->domain->getCombatActions();
        $this->http->setPayload($data);
        return $this->http->execute();
    }
}
