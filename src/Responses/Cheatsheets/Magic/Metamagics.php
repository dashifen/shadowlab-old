<?php

namespace Shadowlab\Responses\Cheatsheets\Magic;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Metamagics extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this view needs a list of the books contained within the powers that
        // we've found.  we'll loop over the powers, collect our list of books, and then pass it all
        // over to the view.

        $books = [];
        $metamagics = $this->payload->getPayload("metamagics");

        foreach ($metamagics as $metamagic) {
            $book_id = $metamagic["book_id"];
            if (!isset($books[$book_id])) {
                $books[$book_id] = $metamagic["book"];
            }
        }

        arsort($books);
        $this->setView('Cheatsheets\Magic\Metamagics', [
            'title'      => 'Metamagic Techniques',
            'metamagics' => $metamagics,
            'books'      => $books,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Magic\Metamagics', [
            'title'      => 'Metamagic Techniques Not Found',
            'books'      => [],
            'metamagics' => [],
        ]);
    }
}