<?php

namespace Shadowlab\Actions\Cheatsheets\Combat;

use Shadowlab\Interfaces\Action\AbstractAction;

class CalledShotsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Combat\CalledShots\CalledShots
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Combat\CalledShots
     */
    protected $http;

    public function execute()
    {
        $data = $this->domain->getCalledShots();
        $this->http->setPayload($data);
        return $this->http->execute();
    }
}
