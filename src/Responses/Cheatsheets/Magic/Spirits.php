<?php

namespace Shadowlab\Responses\Cheatsheets\Magic;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Spirits extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this view needs a list of the books contained within the spirits that
        // we've found.  we'll loop over the spirits, collect our list of books, and then pass it all
        // over to the view.

        $books  = [];
        $spirits = $this->payload->getPayload("spirits");

        foreach ($spirits as $power) {
            $book_id = $power["book_id"];
            if (!isset($books[$book_id])) {
                $books[$book_id] = $power["book"];
            }
        }

        arsort($books);
        $this->setView('Cheatsheets\Magic\Spirits', [
            'title'   => 'Spirits',
            'spirits' => $spirits,
            'books'   => $books,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Magic\Spirits', [
            'title'   => 'Spirits Not Found',
            'books'   => [],
            'spirits' => [],
        ]);
    }
}