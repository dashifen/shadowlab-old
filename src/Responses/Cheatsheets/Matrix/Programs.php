<?php

namespace Shadowlab\Responses\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Programs extends AbstractResponse
{
    protected function handleFound()
    {
        // the search bar for our programs needs to know about the different program types.
        // at the moment, there's only two (common and hacking) but we'll still run through our
        // programs in case we add more as new books come out.

        $program_types = [];
        $programs = $this->payload->getPayload("programs");
        foreach ($programs as $program) {
            $type = $program["program_type"];
            if (!isset($program_types[$type])) {
                $program_types[$type] = 1;
            }
        }

        $program_types = array_keys($program_types);
        sort($program_types);

        $this->setView('Cheatsheets\Matrix\Programs', [
            'programs'      => $programs,
            'program_types' => $program_types,
            'title'         => 'Programs',
        ]);
    }

    protected function handleNotFound()
    {
        $this->setView('Cheatsheets\Matrix\Programs', [
            'title'    => 'Programs Not Found',
            'programs' => []
        ]);
    }
}