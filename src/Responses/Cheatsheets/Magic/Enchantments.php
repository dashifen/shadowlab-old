<?php

namespace Shadowlab\Responses\Cheatsheets\Magic;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Enchantments extends AbstractResponse
{
    protected function handleFound()
    {
        $books  = [];
        $enchantments = $this->payload->getPayload("enchantments");

        foreach ($enchantments as $enchantment) {
            $book_id = $enchantment["book_id"];

            if (!isset($books[$book_id])) {
                $books[$book_id] = $enchantment["book"];
            }
        }

        arsort($books);
        $this->setView('Cheatsheets\Magic\Enchantments', [
            "title"        => "Alchemical Enchantments",
            "enchantments" => $enchantments,
            "books"        => $books,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Magic\Enchantments', [
            "title"        => "Alchemical Enchantments Not Found",
            "books"        => [],
            "enchantments" => [],
        ]);
    }
}