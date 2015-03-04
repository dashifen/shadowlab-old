<?php

namespace Shadowlab\Actions\Cheatsheets;

use Shadowlab\Interfaces\Action\AbstractAction;

class IndexMatrixAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Cheatsheets
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\IndexMatrix
     */
    protected $http;

    public function execute()
    {
        $cheatsheets = $this->domain->getCheatsheets('matrix');
        $this->http->setPayload($cheatsheets);
        return $this->http->execute();
    }
}