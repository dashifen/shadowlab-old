<?php

namespace Shadowlab\Responses\Cheatsheets;

use Shadowlab\Interfaces\Response\AbstractResponse;

class IndexCombat extends AbstractResponse
{
    protected function handleFound()
    {
        // when sheets are found, they're in the "sheets" payload.  we'll grab that and send it to
        // the view for display.  that view also uses the "type" data which, in this case, we don't
        // have.  therefore, we'll just leave it blank.

        $this->setView('Cheatsheets\IndexType', [
            'title'  => 'Cheatsheets:  Combat',
            'sheets' => $this->payload->getPayload('sheets'),
            'type'   => 'combat'
        ]);
    }

    protected function handleNotFound()
    {
        // if we don't find any cheatsheets, we'll just send back blank information for both the
        // cheatsheets array and the type.  this will display the a not-found message re: the sheets
        // with a 200 status (i.e. not a 404 page).

        $this->setView('Cheatsheets\IndexType', [ 'cheatsheets' => '', 'type' => 'combat' ]);
    }
}