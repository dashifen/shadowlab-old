<?php

namespace Shadowlab\Actions\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Action\AbstractAction;

class SpritePowersAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Matrix\SpritePowers\SpritePowers
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Matrix\SpritePowers
     */
    protected $http;

    public function execute()
    {
        $forms = $this->domain->getSpritePowers();
        $this->http->setPayload($forms);
        return $this->http->execute();
    }
}