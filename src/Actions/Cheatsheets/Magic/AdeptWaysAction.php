<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class AdeptWaysAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Magic\AdeptWays\AdeptWays
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Magic\AdeptWays
     */
    protected $http;

    public function execute()
    {
        $data = $this->domain->getAdeptWays();
        $this->http->setPayload($data);
        return $this->http->execute();
    }
}
