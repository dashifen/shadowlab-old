<?php

namespace Shadowlab\Actions\Cheatsheets\Combat;

use Shadowlab\Interfaces\Action\AbstractAction;

class CalledShotsLocationsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Combat\CalledShotsLocations\CalledShotsLocations
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Combat\CalledShotsLocations
     */
    protected $http;

    public function execute()
    {
        $data = $this->domain->getCalledShotsLocations();
        $this->http->setPayload($data);
        return $this->http->execute();
    }
}
