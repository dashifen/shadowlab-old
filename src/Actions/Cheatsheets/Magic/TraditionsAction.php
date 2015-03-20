<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class TraditionsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Magic\Traditions\Traditions
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Magic\Traditions
     */
    protected $http;

    public function execute()
    {
        $data = $this->domain->getTraditions();
        $this->http->setPayload($data);
        return $this->http->execute();
    }
}
