<?php

namespace Shadowlab\Responses\User;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Logout extends AbstractResponse
{
    protected function handleBlank()
    {
        $message = <<<END_OF_MESSAGE

            You have been logged out of the ShadowLab.  <a href="/">Click here</a> to log in again.

END_OF_MESSAGE;

        $data = [
            'title'        => 'Logged Out',
            'message_type' => "success",
            "message"      => $message
        ];

        $this->setView('Blank', $data);
    }
}