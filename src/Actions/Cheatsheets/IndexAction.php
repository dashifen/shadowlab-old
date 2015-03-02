<?php

namespace Shadowlab\Actions\Cheatsheets;

use Shadowlab\Interfaces\Action\AbstractAction;

class IndexAction extends AbstractAction
{
    public function execute()
    {
        $blank_payload = $this->domain->getPayload("blank");
        $this->http->setPayload($blank_payload);
        $this->http->execute();
    }
}