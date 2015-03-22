<?php

namespace Shadowlab\Responses\Cheatsheets\Combat;

use Shadowlab\Interfaces\Response\AbstractResponse;

class MartialArtsTechniques extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for our martial arts uses a list of techniques found within them.  each of our
        // techniques has an array of techniques already.  we'll merge them all together, make sure we remove
        // duplicates, and then sort them for display on screen.

        $styles = [];
        $techniques = $this->payload->getPayload("techniques");

        foreach ($techniques as $technique) {
            foreach ($technique["styles"] as $style_id => $style) {
                if (!isset($styles[$style_id])) {
                    $styles[$style_id] = $style;
                }
            }
        }

        arsort($styles);

        $this->setView('Cheatsheets\Combat\MartialArtsTechniques', [
            'title'      => 'Martial Arts Techniques',
            'techniques' => $techniques,
            'styles'     => $styles,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Combat\MartialArtsTechniques', [
            'title'      => 'Martial Arts Techniques Not Found',
            'techniques' => [],
            'styles'     => [],
        ]);
    }
}