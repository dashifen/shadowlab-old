<?php

namespace Shadowlab\Actions\Cheatsheets\Other;

use Shadowlab\Interfaces\Action\AbstractAction;

class QualitiesAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Other\Qualities\Qualities
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Other\Qualities
     */
    protected $http;

    public function execute()
    {
        $forms = $this->domain->getQualities();
        $this->http->setPayload($forms);
        return $this->http->execute();
    }
}