<?php

namespace Shadowlab\Actions\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Action\AbstractAction;

class IntrusionCountermeasuresAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures\IntrusionCountermeasures
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Matrix\IntrusionCountermeasures
     */
    protected $http;

    public function execute()
    {
        $countermeasures = $this->domain->getIC();
        $this->http->setPayload($countermeasures);
        return $this->http->execute();
    }
}
