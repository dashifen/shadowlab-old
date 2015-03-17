<?php

namespace Shadowlab\Responses\Cheatsheets\Magic;

use Shadowlab\Interfaces\Response\AbstractResponse;

class MentorSpirits extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this view needs a list of the books contained within the powers that
        // we've found.  we'll loop over the powers, collect our list of books, and then pass it all
        // over to the view.

        $books  =  [];
        $mentors = $this->payload->getPayload("mentors");

        foreach ($mentors as $mentor) {
            $book_id = $mentor["book_id"];
            if (!isset($books[$book_id])) {
                $books[$book_id] = $mentor["book"];
            }
        }

        arsort($books);
        $this->setView('Cheatsheets\Magic\MentorSpirits', [
            'title'   => 'Mentor Spirits',
            'mentors' => $mentors,
            'books'   => $books,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Magic\MentorSpirits', [
            'title'   => 'Mentor Spirits Not Found',
            'mentors' => [],
            'books'   => [],
        ]);
    }
}