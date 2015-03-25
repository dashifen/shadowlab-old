<?php

namespace Shadowlab\Actions\User\Accounts;

use Shadowlab\Interfaces\Action\AbstractAction;

class LookUpAction extends AbstractAction
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
        // this action handles any look-up of a person's account based on some set of information.
        // currently, it's in-use only during the password-reset process where we receive an email
        // address and want to find the user account that corresponds to it.  therefore, we're
        // simply using the Reset response at the moment, though we'll need to generalize this later
        // if/when we need to perform look-ups for other reasons.

        $email = $this->request->post->get("email");
        $account = $this->domain->lookUp(["email" => $email]);
        $this->http->setPayload($account);
        return $this->http->execute();
    }
}
