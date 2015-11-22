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
								$prereqs = [];
								$prereq_fields = [
												"metamagics" => "prerequisite_metamagic", 
												"schools" => "prerequisite_metamagic_school", 
												"rituals" => "prerequisite_ritual",
								];

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
												
												foreach ($prereq_fields as $field => $index) {
																if (!empty($ritual[$index])) {
																				if (!isset($prereqs[$field])) {
																								$prereqs[$field] = [];
																				}
																				
																				$prereqs[$field][] = $ritual[$index];
																}
												}
								}

        asort($tags);
        asort($books);
								foreach($prereqs as &$array) {
												$array = array_unique($array);
												sort($array);
								}

        $this->setView('Cheatsheets\Magic\Rituals', [
            'tags'    => $tags,
            'books'   => $books,
            'rituals' => $rituals,
												'prereqs' => $prereqs,
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