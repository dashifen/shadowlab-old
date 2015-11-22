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
    protected $path = '';
    /**
     * @var string
     */
    protected $method = '';

    /**
     * @param Values $server
     * @param array $routes
     * @throws RouteException
     */
    public function __construct(Values $server, array $routes = [])
    {
        $this->method = $server->get("REQUEST_METHOD");
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
    public function getMethod()
    {
        return $this->method;
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

        foreach ($this->routes as $methods) {
            foreach ($methods as $route) {
                if ($new_route->matchRoute($route)) {
                    throw new RouteException("Duplicate route", $new_route);
                }
            }
        }

        $path = $new_route->getPath();
        $method = $new_route->getMethod();

        if (!isset($this->routes[$path])) {
            $this->routes[$path] = [];
        }

        $this->routes[$path][$method] = $new_route;
    }

    /**
     * @return bool|\Shadowlab\Interfaces\Route\AbstractRoute
     */
    public function getRoute()
    {
        return isset($this->routes[$this->path][$this->method])
            ? $this->routes[$this->path][$this->method]
            : false;
    }
}
