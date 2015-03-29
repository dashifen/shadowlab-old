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

        $email = $this->request->post->get("email_address");
        $account = $this->domain->lookUp(["email_address" => $email]);

        // $account is either a found or notFound.  if it's notFound then we're done and we'll let
        // the visitor know that they probably entered the wrong email address.  but, if it's found
        // then we need to actually perform our reset.

        if ($account->getType() == "Found") {
            $account = $this->domain->resetAccount(
                $account->getPayload("account"), $this->request->server->get('SERVER_NAME')
            );
        }

        // after the reset, $account is now either an updated or a notUpdated payload.  or, if it
        // wasn't found at all, then it's still the notFound payload from the lookUp action above.
        // regardless, we'll send it over to our response and send that response back to the
        // visitor.

        $this->http->setPayload($account);
        $this->http->setData(["values" => ["email_address" => $email]]);
        return $this->http->execute();
    }
}
