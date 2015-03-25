<?php

namespace Shadowlab\Actions\User\Accounts;

use Shadowlab\Interfaces\Action\AbstractAction;

class ResetAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\User\User
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\User\Accounts\Reset
     */
    protected $http;

    public function execute()
    {
        $this->http->setPayload( $this->domain->getPayload("blank") );
        return $this->http->execute();
    }
}
