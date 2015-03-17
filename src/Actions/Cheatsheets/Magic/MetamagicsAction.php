<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class MetamagicsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Magic\Metamagics\Metamagics
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Magic\Metamagics
     */
    protected $http;

    public function execute()
    {
        $spells = $this->domain->getMetamagics();
        $this->http->setPayload($spells);
        return $this->http->execute();
    }
}
