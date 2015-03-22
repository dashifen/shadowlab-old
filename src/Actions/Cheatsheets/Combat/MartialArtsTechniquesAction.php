<?php

namespace Shadowlab\Actions\Cheatsheets\Combat;

use Shadowlab\Interfaces\Action\AbstractAction;

class MartialArtsTechniquesAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Combat\MartialArtsTechniques\MartialArtsTechniques
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Combat\MartialArtsTechniques
     */
    protected $http;

    public function execute()
    {
        $data = $this->domain->getMartialArtsTechniques();
        $this->http->setPayload($data);
        return $this->http->execute();
    }
}
