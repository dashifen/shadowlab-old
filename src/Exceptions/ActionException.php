<?php

namespace Shadowlab\Exceptions;

use Shadowlab\Interfaces\Route\Route;

class ActionException extends \Exception
{
    /**
     * @var Route
     */
    protected $route;

    public function __construct($message, Route $route, \Exception $previous = null)
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
