<?php

namespace Shadowlab\Responses\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Response\AbstractResponse;

class SpritePowers extends AbstractResponse
{
    protected function handleFound()
    {
        $this->setView('Cheatsheets\Matrix\SpritePowers', [
            'powers' => $this->payload->getPayload("powers"),
            'title'  => 'Sprite Powers',
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Matrix\SpritePowers', [
            'title'  => 'Sprite Powers Not Found',
            'powers' => []
        ]);
    }
}