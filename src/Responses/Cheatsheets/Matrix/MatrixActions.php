<?php

namespace Shadowlab\Responses\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Response\AbstractResponse;

class MatrixActions extends AbstractResponse
{
    protected function handleFound()
    {
        $this->setView('Cheatsheets\Matrix\MatrixActions', [
            'actions' => $this->payload->getPayload('actions'),
            'title'   => 'Matrix Actions',
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Matrix\MatrixActions', [
            'title'   => 'Actions Not Found',
            'actions' => ''
        ]);
    }
}