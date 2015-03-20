<?php

namespace Shadowlab\Responses\Cheatsheets\Magic;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Traditions extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this view needs a list of the books contained within the traditions that
        // we've found.  we'll loop over the traditions, collect our list of books, and then pass it all
        // over to the view.

        $books = [];
        $traditions = $this->payload->getPayload("traditions");

        foreach ($traditions as $power) {
            $book_id = $power["book_id"];
            if (!isset($books[$book_id])) {
                $books[$book_id] = $power["book"];
            }
        }

        arsort($books);
        $this->setView('Cheatsheets\Magic\Traditions', [
            'title'      => 'Traditions',
            'traditions' => $traditions,
            'books'      => $books,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Magic\Traditions', [
            'title'      => 'Traditions Not Found',
            'books'      => [],
            'traditions' => [],
        ]);
    }
}