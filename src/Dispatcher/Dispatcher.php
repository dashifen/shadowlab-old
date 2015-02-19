<?php

namespace Shadowlab\Dispatcher;

use Aura\Di\Container;
use Aura\Di\Exception\SetterMethodNotFound;
use Aura\Web\Response;
use Shadowlab\Exceptions\ActionException;
use Shadowlab\Interfaces\Routes\AbstractRoute;
use Shadowlab\Router\Router;
use Shadowlab\Session\Session;

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

        if($route === false) $this->notFound();
        elseif(!$route->isPublic() && !$this->session->isAuthenticated()) $this->unauthorized($route);
        else {
            // if we're here, then we're ready to respond to the requested route.  we'll get the
            // action that handles it and use our Container to get a new instance of it and call it's
            // execute method.  that method returns to us the response we wish to send to the
            // visitor.

            try {
                $action = $route->getAction();
                $action = $this->container->newInstance($action);
                $response = $action->execute();
                $this->sendResponse($response);
            } catch (SetterMethodNotFound $e) {
                throw new ActionException("Action not found", $route, $e);
            }
        }
    }

    /**
     * @throws \Aura\Web\Exception\InvalidStatusCode
     */
    public function notFound()
    {
        $this->response->status->setCode(404);
        $this->response->content->set("File Not Found");
        $this->sendResponse();
    }

    /**
     * @param AbstractRoute $route
     */
    public function unauthorized(AbstractRoute $route)
    {
        $this->session->setAfterLoginReturnTo($route->getPath());
        $this->response->redirect->to("/");
        $this->sendResponse();
    }

    /**
     * @param Response $response
     */
    protected function sendResponse(Response $response = null)
    {
        // if we weren't passed a different $response, then we'll use $this->response.  the former
        // is the result of an Action while the latter is the result of calling one of the above two
        // methods.

        if($response === null) $response = $this->response;
        header($response->status->get(), true, $response->status->getCode());

        $headers = $response->headers->get();
        $cookies = $response->cookies->get();
        foreach($headers as $label => $value) header("{$label}: {$value}");
        foreach($cookies as $name => $cookie) setcookie($name, ...$cookie);
        header("Connection: close");

        echo $response->content->get();
    }
}