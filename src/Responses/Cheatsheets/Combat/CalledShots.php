<?php

namespace Shadowlab\Responses\Cheatsheets\Combat;

use Shadowlab\Interfaces\Response\AbstractResponse;

class CalledShots extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this view needs a list of the books contained within the shots that
        // we've found.  we'll loop over the powers, collect our list of books, and then pass it all
        // over to the view.

        $books  = [];
        $shots = $this->payload->getPayload("shots");

        foreach ($shots as $shot) {
            $book_id = $shot["book_id"];
            if (!isset($books[$book_id])) {
                $books[$book_id] = $shot["book"];
            }
        }

        arsort($books);
        $this->setView('Cheatsheets\Combat\CalledShots', [
            'title' => 'Called Shots',
            'shots' => $shots,
            'books' => $books,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Combat\CalledShots', [
            'title' => 'Called Shots Not Found',
            'books' => [],
            'shots' => [],
        ]);
    }
}