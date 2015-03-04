<?php

namespace Shadowlab\Actions\Cheatsheets;

use Shadowlab\Interfaces\Action\AbstractAction;

class IndexOtherAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Cheatsheets
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\IndexOther
     */
    protected $http;

    public function execute()
    {
        $cheatsheets = $this->domain->getCheatsheets('other');
        $this->http->setPayload($cheatsheets);
        return $this->http->execute();
    }
}