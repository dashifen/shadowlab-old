<?php

namespace Shadowlab\Responses\Cheatsheets\Other;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Qualities extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for our response needs to know about the books that are represented
        // within the set of qualities.  we'll loop over them quick to build that list here.

        $books = [];
        $qualities = $this->payload->getPayload("qualities");
        foreach ($qualities as $quality) {
            $book_id = $quality["book_id"];
            if (!isset($books[$book_id])) {
                $books[$book_id] = $quality["book"];
            }
        }

        asort($books);

        $this->setView('Cheatsheets\Other\Qualities', [
            'qualities' => $qualities,
            'books'     => $books,
            'title'     => 'Qualities',
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Other\Qualities', [
            'title'     => 'Qualities Not Found',
            'books'     => [],
            'qualities' => []
        ]);
    }
}