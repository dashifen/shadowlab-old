<?php

namespace Shadowlab\Responses\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Response\AbstractResponse;

class IntrusionCountermeasures extends AbstractResponse
{
    protected function handleFound()
    {
        $this->setView('Cheatsheets\Matrix\IntrusionCountermeasures', [
            'countermeasures' => $this->payload->getPayload('countermeasures'),
            'title'   => 'Intrusion Countermeasures',
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Matrix\IntrusionCountermeasures', [
            'title'   => 'Intrusion Countermeasures Not Found',
            'countermeasures' => []
        ]);
    }
}