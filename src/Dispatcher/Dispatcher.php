<?php

namespace Shadowlab\Dispatcher;

use Aura\Di\Container;
use Aura\Di\Exception\SetterMethodNotFound;
use Shadowlab\Exceptions\ActionException;
use Shadowlab\Interfaces\Route\AbstractRoute;
use Shadowlab\Interfaces\Response\Response;
use Shadowlab\Interfaces\Session;
use Shadowlab\Router\Router;

/**
 * Class Dispatcher
 * @package Shadowlab\Dispatcher
 */
class Dispatcher
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @param Container $container
     * @param Response $response
     * @param Session $session
     * @param Router $router
     */
    public function __construct(
        Container $container,
        Response  $response,
        Session   $session,
        Router    $router
    ) {
        $this->container = $container;
        $this->response  = $response;
        $this->session   = $session;
        $this->router    = $router;
    }

    /**
     * @throws ActionException
     */
    public function dispatch() {
        $route =  $this->router->getRoute();

        // first, we have to see if we know about and can follow this route.  if we couldn't even find
        // a $route, then we'll dispatch a 404 response.  but, if we found one that requires we log in
        // and we're not authenticated, we'll want to redirect them to the login page but with a record
        // of where they are right now so we can return them to the route they wished to follow after
        // authenticating.

        if ($route === false) $this->notFound();
        elseif ($route->isPrivate() && !$this->session->isAuthenticated()) $this->unauthorized($route);
        else {
            // if we're here, then we're ready to respond to the requested route.  we'll get the
            // action that handles it and use our Container to get a new instance of it and call it's
            // execute method.  that method returns to us the response we wish to send to the
            // visitor.

            try {
                $action = $route->getAction();
                $action = $this->container->newInstance($action);
                $response = $action->execute();
            } catch (SetterMethodNotFound $e) {
                throw new ActionException("Action not found", $route, $e);
            }
        }

        if (!isset($response)) {
            $response = $this->response;
        }

        $this->sendResponse($response);
    }

    protected function notFound()
    {
       $this->response->handle404();
    }

    /**
     * @param AbstractRoute $route
     */
    protected function unauthorized(AbstractRoute $route)
    {
        $this->session->set('AFTER_LOGIN_RETURN_TO', $route->getPath());
        $this->response->unauthorized();
    }

    /**
     * @param Response $response
     */
    protected function sendResponse(Response $response)
    {
        $response->setData([ 'isAuthenticated' => $this->session->isAuthenticated() ]);
        $response->send();
    }
}