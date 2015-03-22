<?php

namespace Shadowlab\Responses\Cheatsheets\Combat;

use Shadowlab\Interfaces\Response\AbstractResponse;

class MartialArts extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for our martial arts uses a list of techniques found within them.  each of our
        // styles has an array of techniques already.  we'll merge them all together, make sure we remove
        // duplicates, and then sort them for display on screen.

        $skills = [];
        $techniques = [];
        $styles = $this->payload->getPayload("styles");
        foreach ($styles as $style) {
            $techniques = array_merge($techniques, $style["techniques"]);
            $skills[] = $style["skill_group"];
            $skills[] = $style["skill"];
        }

        $skills = array_unique($skills);
        $techniques = array_unique($techniques);
        arsort($techniques);
        sort($skills);

        $this->setView('Cheatsheets\Combat\MartialArts', [
            'title'      => 'Martial Arts',
            'techniques' => $techniques,
            'skills'     => $skills,
            'styles'     => $styles,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Combat\MartialArts', [
            'title'      => 'Martial Arts Not Found',
            'techniques' => [],
            'skills'     => [],
            'styles'     => [],
        ]);
    }
}