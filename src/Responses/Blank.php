<?php

namespace Shadowlab\Responses;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Blank extends AbstractResponse
{
    protected function handleBlank()
    {
        $this->setView('Blank', [ 'title' => '', 'username' => '' ]);
    }
}
