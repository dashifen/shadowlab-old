<?php

namespace Shadowlab\Interfaces\Action;

use Aura\Web\Request;
use Shadowlab\Interfaces\Domain\Domain;
use Shadowlab\Interfaces\Response\Response;
use Shadowlab\Interfaces\Session;


abstract class AbstractAction implements Action
{
    /**
     * @var Domain;
     */
    protected $domain;

    /**
     * @var Response;
     */
    protected $http;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @param Domain $domain
     * @param Request $request
     * @param Session $session
     * @param Response $http
     */
    public function __construct(
        Domain   $domain,
        Request  $request,
        Session  $session,
        Response $http
    ) {
        $this->domain  = $domain;
        $this->request = $request;
        $this->session = $session;
        $this->http    = $http;
    }

    abstract public function execute();
}