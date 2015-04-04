<?php

namespace Shadowlab\Actions\User\Accounts;

use Shadowlab\Interfaces\Action\AbstractAction;

class ReconfirmAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\User\User
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\User\Accounts\Reconfirm
     */
    protected $http;

    public function execute()
    {
        // this action handles the first step of the reconfirmation of a person's account.  it shows a form
        // on screen to collect the email address and confirmation code for an account which we then use to
        // look-up their information.

        $this->http->setPayload( $this->domain->getPayload("blank") );
        return $this->http->execute();
    }
}
