<?php

namespace Shadowlab\Responses\Cheatsheets;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Index extends AbstractResponse
{
    protected function handleBlank()
    {
        $data = [
            'title' => 'Cheatsheets',
        ];

        $this->setView('Cheatsheets\Index', $data);
    }
}