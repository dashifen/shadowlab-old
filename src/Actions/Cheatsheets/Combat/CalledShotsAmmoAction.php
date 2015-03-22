<?php

namespace Shadowlab\Actions\Cheatsheets\Combat;

use Shadowlab\Interfaces\Action\AbstractAction;

class CalledShotsAmmoAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Combat\CalledShotsAmmo\CalledShotsAmmo
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Combat\CalledShotsAmmo
     */
    protected $http;

    public function execute()
    {
        $data = $this->domain->getCalledShotsAmmo();
        $this->http->setPayload($data);
        return $this->http->execute();
    }
}
