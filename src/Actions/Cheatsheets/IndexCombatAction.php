<?php

namespace Shadowlab\Actions\Cheatsheets;

use Shadowlab\Interfaces\Action\AbstractAction;

class IndexCombatAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Cheatsheets
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\IndexCombat
     */
    protected $http;

    public function execute()
    {
        $cheatsheets = $this->domain->getCheatsheets('combat');
        $this->http->setPayload($cheatsheets);
        return $this->http->execute();
    }
}