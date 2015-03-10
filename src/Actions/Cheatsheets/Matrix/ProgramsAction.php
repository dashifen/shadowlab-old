<?php

namespace Shadowlab\Actions\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Action\AbstractAction;

class ProgramsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Matrix\Programs\Programs
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Matrix\Programs
     */
    protected $http;

    public function execute()
    {
        $forms = $this->domain->getPrograms();
        $this->http->setPayload($forms);
        return $this->http->execute();
    }
}