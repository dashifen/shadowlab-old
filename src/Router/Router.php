<?php

namespace Shadowlab\Router;

use Aura\Web\Request\Values;
use Shadowlab\Exceptions\RouteException;
use Shadowlab\Interfaces\Route\Route;

/**
 * Class Router
 * @package Shadowlab\Router
 */
class Router
{
    /**
     * @var array
     */
    protected $routes = [];
    /**
     * @var string
     */
    protected $path   = '';
    /**
     * @var string
     */
    protected $type   = '';

    /**
     * @param Values $server
     * @param array $routes
     * @throws RouteException
     */
    public function __construct(Values $server, array $routes = [])
    {
        $this->type = $server->get("REQUEST_METHOD");
        $this->path = parse_url($server->get("REQUEST_URI"), PHP_URL_PATH);
        foreach ($routes as $route) $this->addRoute($route);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Route $new_route
     * @throws RouteException
     */
    public function addRoute(Route $new_route)
    {
        // this application only functions when each route is a unique pairing of both path and request
        // type (i.e. GET or POST).  but, we can have the same path as long as one uses the GET method and
        // the other uses POST.  luckily, we have a matchRoute() method for our Route objects which we can
        // use to be sure we don't have a problem right from the get-go.

        foreach ($this->routes as $route) {
            if ($new_route->matchRoute($route)) {
                throw new RouteException("Duplicate route", $route);
            }
        }

        $this->routes[$new_route->getPath()] = $new_route;
    }

    /**
     * @return bool|Routes\GetRoute|Routes\PostRoute
     */
    public function getRoute()
    {
        return isset($this->routes[$this->path])
            ? $this->routes[$this->path]
            : false;
    }
}
