<?php

namespace Shadowlab\Exceptions;

/**
 * Class RouteException
 * @package Shadowlab\Exceptions
 */
class RouteException extends \Exception
{
    /**
     * @var string
     */
    protected $route;

    /**
     * @param string $message
     * @param string $route
     * @param \Exception $previous
     */
    public function __construct($message, $route = '', \Exception $previous = null)
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
