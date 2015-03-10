<?php

namespace Shadowlab\Actions\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Action\AbstractAction;

class ComplexFormsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms\ComplexForms
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Matrix\ComplexForms
     */
    protected $http;

    public function execute()
    {
        $forms = $this->domain->getComplexForms();
        $this->http->setPayload($forms);
        return $this->http->execute();
    }
}