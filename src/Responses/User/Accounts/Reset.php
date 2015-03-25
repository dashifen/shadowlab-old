<?php

namespace Shadowlab\Responses\User\Accounts;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Reset extends AbstractResponse
{
    protected function handleBlank()
    {
        $this->setView('User\Accounts\Reset', ["title" => "Reset Account"]);
    }
}
