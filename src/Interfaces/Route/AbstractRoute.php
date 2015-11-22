<?php

namespace Shadowlab\Interfaces\Route;

/**
 * Class AbstractRoute
 * @package Shadowlab\Interfaces\Route
 */
abstract class AbstractRoute implements Route
{
    /**
     * @var string - the name of the action that handles this route
     */
    protected $action = '';
    /**
     * @var string - whether this is a public or private route
     */
    protected $access = '';
    /**
     * @var string - the path (i.e. url) of the route
     */
    protected $path   = '';
    /**
     * @var string - the request method (i.e. GET or POST) of the route
     */
    protected $method;

    /**
     * @param $path
     * @param $action
     * @param $access
     */
    public function __construct($path, $action, $access)
    {
        $this->path = $path;
        $this->action = $action;
        $this->access = $access;
    }

    public function __toString()
    {
        return sprintf("%s (%s, %s)", $this->path, strtoupper($this->method), $this->access);
    }

    /**
     * @return bool
     */
    public function isPrivate()
    {
        return $this->access == 'private';
    }

    /**
     * @return string
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
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
     * @param Route $route
     * @return bool
     */
    public function matchRoute(Route $route)
    {
        return $route->getMethod() == $this->method && $route->getPath() == $this->path;
    }
}