<?php

namespace Shadowlab\Responses\Cheatsheets\Combat;

use Shadowlab\Interfaces\Response\AbstractResponse;

class CalledShotsLocations extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for this view needs a list of the location types used in these called shot enhancements.
        // we'll loop over tour set of locations and find them now.

        $types = [];
        $locations = $this->payload->getPayload("locations");

        foreach ($locations as $location) {
            $location_type = $location["location_type"];
            if (!isset($types[$location_type])) {
                $types[$location_type] = 1;
            }
        }

        $types = array_keys($types);
        sort($types);

        $this->setView('Cheatsheets\Combat\CalledShotsLocations', [
            'title'     => 'Called Shots: Locations',
            'locations' => $locations,
            'types'     => $types,
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Combat\CalledShotsLocations', [
            'title'     => 'Called Shots: Locations Not Found',
            'locations' => [],
            'types'     => [],
        ]);
    }
}