<?php

namespace Shadowlab\Responses\User\Accounts;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Reset extends AbstractResponse
{
    protected function handleBlank()
    {
        $this->setView('User\Accounts\Reset', ["title" => "Reset Account"]);
    }

    protected function handleUpdated()
    {
        // this is actually our success case here.  when an account is found and reset, we've
        // updated it with a blank password and a reset vector.  here we actually want to send
        // two responses:  the information we put on-screen as well as an email message that
        // is sent to the account holder with further instructions.



    }

    protected function handleNotUpdated()
    {

    }

    protected function handleNotFound()
    {
        $this->setView('User\Accounts\ResetNotFound', [
            "errors" => ["email_address" => "An account using the address you entered could not be found."],
            "title"  => "Account Not Found",
        ]);
    }
}
