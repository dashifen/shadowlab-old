<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class SpellsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Magic\Spells\Spells
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Magic\Spells
     */
    protected $http;

    public function execute()
    {
        $spells = $this->domain->getSpells();
        $this->http->setPayload($spells);
        return $this->http->execute();
    }
}
