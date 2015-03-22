<?php

namespace Shadowlab\Actions\Cheatsheets\Combat;

use Shadowlab\Interfaces\Action\AbstractAction;

class MartialArtsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Combat\MartialArts\MartialArts
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Combat\MartialArts
     */
    protected $http;

    public function execute()
    {
        $data = $this->domain->getMartialArts();
        $this->http->setPayload($data);
        return $this->http->execute();
    }
}
