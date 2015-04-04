<?php

namespace Shadowlab\Responses\User\Accounts;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Reconfirm extends AbstractResponse
{
    protected function handleBlank()
    {
        $this->setView('User\Accounts\Reconfirm\Reconfirm', ["title" => "Reconfirm Account"]);
    }
}
