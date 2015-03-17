<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class SpiritPowersAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Magic\SpiritPowers\SpiritPowers
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Magic\SpiritPowers
     */
    protected $http;

    public function execute()
    {
        $data = $this->domain->getSpiritPowers();
        $this->http->setPayload($data);
        return $this->http->execute();
    }
}
