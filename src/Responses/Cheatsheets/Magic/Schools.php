<?php

namespace Shadowlab\Responses\Cheatsheets\Magic;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Schools extends AbstractResponse
{
    protected function handleFound()
    {
        $books = [];
        $types = [];
        $schools = $this->payload->getPayload("schools");
        foreach ($schools as $school) {
            $book_id = $school["book_id"];
            $school_type = $school["school_type"];

            if (!isset($books[$book_id])) {
                $books[$book_id] = $school["book"];
            }

            if (!isset($types[$school_type])) {
                $types[$school_type] = $school_type;
            }
        }

        $this->setView('Cheatsheets\Magic\Schools', [
            "title"   => "Metamagic Schools and Adept Ways",
            "schools" => $schools,
            "types"   => $types,
            "books"   => $books,
        ]);

    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Magic\Schools', [
            "title"   => "Schools and Ways Not Found",
            "schools" => [],
            "types"   => [],
            "books"   => [],
        ]);
    }
}