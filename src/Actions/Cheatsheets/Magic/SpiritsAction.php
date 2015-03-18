<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class SpiritsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Magic\Spirits\Spirits
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Magic\Spirits
     */
    protected $http;

    public function execute()
    {
        $data = $this->domain->getSpirits();
        $this->http->setPayload($data);
        return $this->http->execute();
    }
}
