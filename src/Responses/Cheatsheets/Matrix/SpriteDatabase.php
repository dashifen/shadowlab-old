<?php

namespace Shadowlab\Responses\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Response\AbstractResponse;

class SpriteDatabase extends AbstractResponse
{
    protected function handleFound()
    {
        $this->setView('Cheatsheets\Matrix\SpriteDatabase', [
            'sprites' => $this->payload->getPayload('sprites'),
            'title' => 'Sprites',
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Matrix\SpriteDatabase', [
            'title'   => 'Sprites Not Found',
            'sprites' => []
        ]);
    }
}