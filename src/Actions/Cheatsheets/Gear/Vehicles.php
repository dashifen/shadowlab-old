<?php

namespace Shadowlab\Actions\Cheatsheets\Gear;

use Shadowlab\Interfaces\Action\AbstractAction;

class Vehicles extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Gear\Vehicles\Vehicles
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Gear\Vehicles
     */
    protected $http;

    public function execute()
    {
        $vehicles = $this->domain->getVehicles();
        $this->http->setPayload($vehicles);
        return $this->http->execute();
    }
}
