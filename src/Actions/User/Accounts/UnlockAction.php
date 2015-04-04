<?php

namespace Shadowlab\Actions\User\Accounts;

use Shadowlab\Interfaces\Action\AbstractAction;

class UnlockAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\User\User
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\User\Accounts\Unlock
     */
    protected $http;

    public function execute()
    {
        $user_id = $this->request->post->get("uesr_id");
        $account = $this->domain->lookUp(["user_id" => $user_id]);
        $error = [];

        // $payload is either a found or notFound.  if it's notFound then we're done and, frankly, we've
        // probably got a problem since we're looking up information related to this account using it's
        // numeric ID.  thus, if we didn't find it, something went wrong in the original reconfirmation
        // step when we looked it up (see the lookup action).

        if ($account->getType() == "Found") {

            // if the account was found, then we want to set it's password.  but, while the javascript
            // on the client side should have ensured that someone sent us both a valid password and a
            // confirmed one, we want to be sure to check that here on the server side, too.

            $password = $this->request->post->get("password");
            $confirmation = $this->request->post->get("confirmation");
            $payload = $this->domain->isPasswordValid($password, $confirmation);

            // the $passwordCheck will be either a valid or notValid payload.  if it's notValid, like
            // when we couldn't find the account at all, we're done. if it's a valid payload, then our
            // password checks out and we'll want to actually update our account.

            if ($payload->getType() == "Valid") {
                $account = $this->domain->setPassword($account->getPayload("account"), $password);
            } else {
                $error = $payload->getPayload("error");
                $account = $payload;
            }
        }

        // after the above, our $account is a variety of types.  we'll pass that payload over to our
        // Response along with any errors that were identified during this process.

        $this->http->setPayload($account);
        $this->http->setData(["errors" => $error]);
        return $this->http->execute();
    }
}
