<?php

namespace Shadowlab\Responses\Cheatsheets;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Index extends AbstractResponse
{
    protected function handleFound()
    {
        // when sheets are found, they're in the "sheets" payload.  we'll grab that and send it to
        // the view for display.

        $this->setView('Cheatsheets\Index', [
            'title'  => 'Cheatsheets',
            'sheets' => $this->payload->getPayload('sheets'),
        ]);
    }

    protected function handleNotFound()
    {
        // if we don't find any cheatsheets, we'll just send back blank information for the
        // cheatsheets array.  this will display the a not-found message re: the sheets with
        // a 200 status (i.e. not a 404 page).

        $this->setView('Cheatsheets\Index', [ 'cheatsheets' => '' ]);
    }
}