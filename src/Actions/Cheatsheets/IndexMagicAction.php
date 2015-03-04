<?php

namespace Shadowlab\Actions\Cheatsheets;

use Shadowlab\Interfaces\Action\AbstractAction;

class IndexMagicAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Cheatsheets
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\IndexMagic
     */
    protected $http;

    public function execute()
    {
        $cheatsheets = $this->domain->getCheatsheets('magic');
        $this->http->setPayload($cheatsheets);
        return $this->http->execute();
    }
}