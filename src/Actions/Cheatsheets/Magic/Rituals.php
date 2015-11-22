<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class Rituals extends AbstractAction
{
    public function execute()
    {
        $rituals = $this->domain->getRituals();
        $this->http->setPayload($rituals);
        return $this->http->execute();
    }
}
