<?php

namespace Shadowlab\Actions\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Action\AbstractAction;

class MatrixActionsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActions
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Matrix\MatrixActions
     */
    protected $http;

    public function execute()
    {
        $actions = $this->domain->getMatrixActions();
        $this->http->setPayload($actions);
        return $this->http->execute();
    }
}
