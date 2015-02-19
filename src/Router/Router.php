<?php

namespace Shadowlab\Router;

use Shadowlab\Router\Route\RouteInterface;
use Shadowlab\Exceptions\RouteException;

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
    protected $type = '';

    /**
     * @param array $server
     * @param array $routes
     * @throws RouteException
     */
    public function __construct(array $server, array $routes = [])
    {
        $this->type = $server['REQUEST_METHOD'];
		$this->path = parse_url($server['REQUEST_URI'], PHP_URL_PATH);
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
        // for this application, we want to strictly enforce that no two routes may match.  this
        // helps us quickly identify the route we wish to follow via a simple array access rather
        // than any other more complicated logic.  using the route's path facilitates this look-
        // up.

        $path = $route->getPath();
        if(isset($this->routes[$path])) throw new RouteException("Duplicate route", $route);
        $this->routes[$path] = $route;
    }

    /**
     * @return bool|Route\GetRoute|Route\PostRoute;
     */
    public function getRoute()
    {
        // if we know about the requested path, then we've found our matching route.  if not, we
        // return false and the calling scope can deal with that.

        return isset($this->routes[$this->path])
            ? $this->routes[$this->path]
            : false;
    }
}
