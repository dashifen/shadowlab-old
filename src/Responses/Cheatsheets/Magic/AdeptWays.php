<?php

namespace Shadowlab\Responses\Cheatsheets\Magic;

use Shadowlab\Interfaces\Response\AbstractResponse;

class AdeptWays extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this view needs a list of the books contained within the powers that
        // we've found.  we'll loop over the powers, collect our list of books, and then pass it all
        // over to the view.

        $this->setView('Cheatsheets\Magic\AdeptWays', [
            'ways'  => $this->payload->getPayload("ways"),
            'title' => 'Adept Ways',
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Magic\AdeptWays', [
            'title' => 'Adept Ways Not Found',
            'ways'  => [],
        ]);
    }
}