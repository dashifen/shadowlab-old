<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class Rituals extends AbstractAction
{
    public function execute()
    {
        $spells = $this->domain->getRituals();
        $this->http->setPayload($spells);
        return $this->http->execute();
    }
}
