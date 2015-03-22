<?php

namespace Shadowlab\Actions\User;

use Shadowlab\Interfaces\Action\AbstractAction;

class LogoutAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\User\User
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\User\Logout
     */
    protected $http;

    public function execute()
    {
        $this->session->logout();
        $payload = $this->domain->getPayload("blank");
        $this->http->setPayload($payload);
        return $this->http->execute();
    }
}
