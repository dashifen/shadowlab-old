<?php

namespace Shadowlab\Responses\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Response\AbstractResponse;

class ComplexForms extends AbstractResponse
{
    protected function handleFound()
    {
        $this->setView('Cheatsheets\Matrix\ComplexForms', [
            'forms' => $this->payload->getPayload('forms'),
            'title' => 'Complex Forms',
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Matrix\ComplexForms', [
            'title' => 'Complex Forms Not Found',
            'forms' => []
        ]);
    }
}