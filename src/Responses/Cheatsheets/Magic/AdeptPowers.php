<?php

namespace Shadowlab\Responses\Cheatsheets\Magic;

use Shadowlab\Interfaces\Response\AbstractResponse;

class AdeptPowers extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this view needs a list of the books contained within the powers that
        // we've found.  we'll loop over the powers, collect our list of books, and then pass it all
        // over to the view.

        $books  = [];
        $powers = $this->payload->getPayload("powers");

        foreach ($powers as $power) {
            $book_id = $power["book_id"];
            if (!isset($books[$book_id])) {
                $books[$book_id] = $power["book"];
            }
        }

        arsort($books);
        $this->setView('Cheatsheets\Magic\AdeptPowers', [
            'title'  => 'Adept Powers',
            'powers' => $powers,
            'books'  => $books,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Magic\AdeptPowers', [
            'title'  => 'Adept Powers Not Found',
            'books'  => [],
            'powers' => [],
        ]);
    }
}