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

        $books = [];
								$traditions = [];
        $spirits = $this->payload->getPayload("spirits");

        foreach ($spirits as $spirit) {
            $book_id = $spirit["book_id"];
            if (!isset($books[$book_id])) {
                $books[$book_id] = $spirit["book"];
            }
												
												$traditions = array_merge($traditions, $spirit["traditions"]);
        }

        arsort($books);
								$traditions = array_unique($traditions);
								sort($traditions);
								
        $this->setView('Cheatsheets\Magic\Spirits', [
            'title'      => 'Spirits',
            'spirits'    => $spirits,
												'traditions' => $traditions,
            'books'      => $books,
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