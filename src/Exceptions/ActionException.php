<?php

namespace Shadowlab\Exceptions;

use Shadowlab\Interfaces\Routes\AbstractRoute;

class ActionException extends \Exception
{
    /**
     * @var \Shadowlab\Router\Route\GetRoute|\Shadowlab\Router\Route\GetRoute
     */
    protected $route;

    public function __construct($message, AbstractRoute $route, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->setRoute($route);
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }
}
