<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class MentorSpiritsAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits\MentorSpirits
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Magic\MentorSpirits
     */
    protected $http;

    public function execute()
    {
        $spells = $this->domain->getMentorSpirits();
        $this->http->setPayload($spells);
        return $this->http->execute();
    }
}
