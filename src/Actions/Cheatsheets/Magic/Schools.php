<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class Schools extends AbstractAction
{
    public function execute()
    {
        $schools = $this->domain->getSchools();
        $this->http->setPayload($schools);
        return $this->http->execute();
    }
}
