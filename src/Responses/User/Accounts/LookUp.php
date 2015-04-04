<?php

namespace Shadowlab\Responses\User\Accounts;

use Shadowlab\Interfaces\Response\AbstractResponse;

class LookUp extends AbstractResponse
{
    protected function handleUpdated()
    {
        // this is one of our success cases.  when an account is found and reset, we've
        // updated it with a blank password and a reset vector.  the User domain will have
        // tried to send an email with that vector in it to the account's owner.  if it
        // could do so, then our message payload will tell us whether or not it was
        // successful.

        $payload = $this->payload;
        $message = $payload->getPayload("message");
        $this->setView('User\Accounts\LookUp\Reset', [
            "title"   => $message ? "Account Reset" : "Uhm... Crap.",
            "success" => $message
        ]);
    }

    protected function handleNotUpdated()
    {
        $this->setView('User\Accounts\LookUp\NotReset', ["title" => "Unable to Reset Account"]);
    }

    protected function handleValid()
    {
        $this->setView('User\Accounts\LookUp\Unlock', [
            "user_id" => $this->payload->getPayload("account")->get("user_id"),
            "title"   => "Set Password"
        ]);
    }

    protected function handleNotValid()
    {
        $this->setView('User\Accounts\LookUp\NotConfirmed', ["title" => "Unable to Reconfirm Account"]);
    }

    protected function handleNotFound()
    {
        $this->setView('User\Accounts\LookUps\NotFound', [
            "errors" => ["email_address" => "An account using the address you entered could not be found."],
            "title"  => "Account Not Found",
        ]);
    }
}
