<?php

namespace Shadowlab\Responses;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Blank extends AbstractResponse
{
    protected function blank()
    {
        $data = [
            'title'    => 'Home',
            'username' => ''
        ];

        $this->render('Blank', $data);
    }

}