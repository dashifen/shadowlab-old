<?php

namespace Shadowlab\Actions\Cheatsheets;

use Shadowlab\Interfaces\Action\AbstractAction;

class IndexAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Cheatsheets
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Index
     */
    protected $http;

    public function execute()
    {
        $cheatsheets = $this->domain->getCheatsheets();
        $this->http->setPayload($cheatsheets);
        return $this->http->execute();
    }
}