<?php

namespace Shadowlab\Responses\User;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Login extends AbstractResponse
{
    protected function handleBlank()
    {
        $data = [
            'title'    => 'Home',
            'username' => '',
        ];

        $this->setView('User\Login', $data);
    }

    protected function handleNotFound()
    {
        $this->setView('User\Login', [ 'title' => 'Home' ]);
    }

    protected function handleFound()
    {
        // in the case of a user account that we've found we actually redirect to the list
        // of cheat sheets.

        $this->http->redirect->to("/cheatsheets");
    }
}