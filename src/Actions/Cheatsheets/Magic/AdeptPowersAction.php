<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class AdeptPowersAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers\AdeptPowers
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Magic\AdeptPowers
     */
    protected $http;

    public function execute()
    {
        $data = $this->domain->getAdeptPowers();
        $this->http->setPayload($data);
        return $this->http->execute();
    }
}
