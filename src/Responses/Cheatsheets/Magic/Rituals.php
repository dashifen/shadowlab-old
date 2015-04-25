<?php

namespace Shadowlab\Responses\Cheatsheets\Magic;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Rituals extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this view is complicated because of the information related to ritual tags and
        // multiple books.  before we send everything to our view, we'll get some of that information from our
        // payload.

        $tags = [];
        $books = [];

        $rituals = $this->payload->getPayload('rituals');
        foreach ($rituals as $ritual) {
            $book_id = $ritual['book_id'];
            if (!isset($books[$book_id])) {
                $books[$book_id] = $ritual['book'];
            }

            $ritual_tags = $ritual["ritual_tags"];
            foreach ($ritual_tags as $tag_id => $tag) {
                if (!isset($tags[$tag_id])) {
                    $tags[$tag_id] = $tag;
                }
            }
        }

        asort($tags);
        asort($books);

        $this->setView('Cheatsheets\Magic\Rituals', [
            'tags'    => $tags,
            'books'   => $books,
            'rituals' => $rituals,
            'title'   => 'Rituals'
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Magic\Rituals', [
            'title'   => 'Rituals Not Found',
            'rituals' => []
        ]);
    }
}