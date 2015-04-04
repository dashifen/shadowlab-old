<?php

namespace Shadowlab\Responses\User\Accounts;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Unlock extends AbstractResponse
{
    protected function handleNotFound()
    {
        $this->setView('User\Accounts\Unlock\NotFound', ["title" => "Account Not Found"]);
    }
    protected function handleUpdated()
    {
        $this->setView('User\Accounts\Unlock\Unlocked', ["title" => "Account Unlocked"]);
    }

    protected function handleNotValid()
    {
        $this->handleNotUpdated("Password Invalid");
    }

    protected function handleNotUpdated($title = null)
    {
        // notice tat we load a view from the LookUp folder because it's already showing the form
        // which is used to unlock an account.  when we can't update the account with the password
        // sent to us from the visitor, we want to re-load that form for them so they can try
        // again.

        if ($title === null) {
            $title = "Unable to Unlock Account";
        }

        $this->setView('User\Accounts\LookUp\Unlock', ["title" => $title]);
    }
}
