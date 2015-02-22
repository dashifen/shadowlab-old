<?php

namespace Shadowlab\Interfaces\Action;

use Aura\Web\Response;
use Shadowlab\Interfaces\Session;
use Shadowlab\Interfaces\Domain\Domain;
use Shadowlab\Pages\Page;

abstract class AbstractAction implements Action
{
    /**
     * @var Domain;
     */
    protected $domain;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Page
     */
    protected $page;

    /**
     * @param Domain $domain
     * @param Response $response
     * @param Session $session
     * @param Page $page
     */
    public function __construct(
        Domain $domain,
        Response $response,
        Session $session,
        Page $page
    ) {
        $this->domain   = $domain;
        $this->response = $response;
        $this->session  = $session;
        $this->page     = $page;
    }

    abstract public function execute();
}