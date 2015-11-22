<?php

namespace Shadowlab\Responses\Cheatsheets\Gear;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Vehicles extends AbstractResponse
{
    protected function handleFound()
    {
        $books = [];
        $categories = [];
        $vehicles = $this->payload->getPayload("vehicles");
        foreach ($vehicles as $vehicle) {
            if (!isset($books[$vehicle["book_id"]])) {
                $books[$vehicle["book_id"]] = $vehicle["book"];
            }

            $parent = $vehicle["parent"];
            $category = $vehicle["category"];
            if (!isset($categories[$parent])) {
                $categories[$parent] = [];
            }

            $categories[$parent][] = $category;
        }

        asort($books);
        ksort($categories);
        foreach ($categories as $parent => &$children) {
            $children = array_unique($children);
            asort($children);
        }

        $this->setView('Cheatsheets\Gear\Vehicles', [
            "title"      => "Vehicles and Drones",
            "categories" => $categories,
            "vehicles"   => $vehicles,
            "books"      => $books,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Gear\Vehicles', [
            "title"      => "Neither Vehicles nor Drones Found",
            "categories" => [],
            "vehicles"   => [],
            "books"      => [],
        ]);
    }
}