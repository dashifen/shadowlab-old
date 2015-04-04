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
     * @var \Shadowlab\Responses\User\Accounts\LookUp
     */
    protected $http;

    public function execute()
    {
        $email = $this->request->post->get("email_address");
        $account = $this->domain->lookUp(["email_address" => $email]);

        // $account is either a found or notFound.  if it's notFound then we're done and we'll let
        // the visitor know that they probably entered the wrong email address.  but, if it's found
        // then we need to perform one of two actions based on the existence of a a reset vector
        // within the posted data.

        if ($account->getType() == "Found") {
            $reset_vector = $this->request->post->get("reset_vector");
            $account = $account->getPayload("account");

            if (empty($reset_vector)) {
                $account = $this->domain->resetAccount($account, $this->request->server->get('SERVER_NAME'));
            } else {
                $account = $this->domain->confirmVector($account, $reset_vector);
            }

        }

        // after the above block we have a few options for our $account.  it could be any of the following
        // payloads:  notFound, notUpdated, notValid, Updated, or Valid.  regardless, we pass the information
        // related to our our Response and let it handle things based on the payload type as normal.

        $this->http->setPayload($account);

        $this->http->setData([
            "values" => ["email_address" => $email, "reset_vector" => $reset_vector]
        ]);

        return $this->http->execute();
    }
}
