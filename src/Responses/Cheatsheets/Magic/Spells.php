<?php

namespace Shadowlab\Responses\Cheatsheets\Magic;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Spells extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this view is complicated because of the information related to spell categories,
        // spell tags, and the multiple books within these data.  before we send everything to our view, we'll
        // need to get some of that information.

        $tags  = [];
        $books = [];
        $categories = [];

        $spells = $this->payload->getPayload('spells');
        foreach ($spells as $spell) {
            $spell_category_id = $spell['spell_category_id'];
            if (!isset($categories[$spell_category_id])) {
                $categories[$spell_category_id] = $spell['spell_category'];
            }

            $book_id = $spell['book_id'];
            if (!isset($books[$book_id])) {
                $books[$book_id] = $spell['book'];
            }

            // the above two are fairly simple because there's only one category and book per spell.  but,
            // because there can be multiple tags for a spell, we need to explode the tags and tag IDs based
            // on the commas that the database has put between them.

            $spell_tags = explode(",", $spell['spell_tags']);
            $spell_tags_ids = explode(",", $spell['spell_tags_ids']);
            foreach ($spell_tags_ids as $i => $id) {
                if (!isset($tags[$id])) {
                    $tags[$id] = [$spell_category_id, $spell_tags[$i]];
                }
            }
        }

        asort($books);
        asort($categories);
        uasort($tags, function($a, $b) { return $a[1] < $b[1] ? -1 : 1; });

        $this->setView('Cheatsheets\Magic\Spells', [
            'tags'       => $tags,
            'books'      => $books,
            'categories' => $categories,
            'spells'     => $this->payload->getPayload('spells'),
            'title'      => 'Spells'
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Magic\Spells', [
            'title'  => 'Spells Not Found',
            'spells' => []
        ]);
    }
}