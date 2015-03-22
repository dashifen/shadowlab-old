<?php

namespace Shadowlab\Responses\Cheatsheets\Combat;

use Shadowlab\Interfaces\Response\AbstractResponse;

class CalledShotsAmmo extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this view needs a list of the ammunition used in these called shot enhancements.
        // we'll loop over tour set of shots and find them now.

        $ammo  = [];
        $shots = $this->payload->getPayload("shots");

        foreach ($shots as $shot) {
            $ammo_type = $shot["ammo_type"];
            $ammo_list = explode(", ", $ammo_type);
            $ammo = array_merge($ammo, $ammo_list);
        }

        $ammo = array_unique($ammo);
        sort($ammo);

        $this->setView('Cheatsheets\Combat\CalledShotsAmmo', [
            'title' => 'Called Shots: Ammo Enhancements',
            'shots' => $shots,
            'ammo'  => $ammo,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Combat\CalledShotsAmmo', [
            'title' => 'Called Shots: Ammo Enhancements Not Found',
            'shots' => [],
            'ammo'  => [],
        ]);
    }
}