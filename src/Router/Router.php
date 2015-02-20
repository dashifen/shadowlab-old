<?php

namespace Shadowlab\Router;

use Shadowlab\Exceptions\RouteException;
use Shadowlab\Interfaces\Route\RouteInterface;

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
     * @param array $server
     * @param array $routes
     * @throws RouteException
     */
    public function __construct(array $server, array $routes = [])
    {
        $this->type = $server["REQUEST_METHOD"];
        $this->path = parse_url($server["REQUEST_URI"], PHP_URL_PATH);
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
     * @param RouteInterface $route
     * @throws RouteException
     */
    public function addRoute(RouteInterface $route)
    {
        // this application only functions when each route contains a unique path.  therefore, before we
        // ad this $route to the list of $routes, we'll double check to be sure it's unique and, if not
        // we throw an exception.

        $path = $route->getPath();
        if (isset($this->routes[$path])) throw new RouteException("Duplicate route", $route);
        $this->routes[$path] = $route;
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
