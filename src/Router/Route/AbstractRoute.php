<?php

namespace Shadowlab\Router\Route;

/**
 * Class AbstractRoute
 * @package Shadowlab\Interfaces\Routes
 */
abstract class AbstractRoute implements RouteInterface {
    /**
     * @var string $action
     */
    protected $action;

    /**
     * @var string $path
     */
    protected $path;

    /**
     * @var string $access
     */
    protected $access;

    /**
     * @param string $path
     * @param string $action
     * @param string $access
     */
    public function __construct($path, $action, $access) {
		$this->path  = $path;
        $this->action = $action;
        $this->access = $access;
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
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @return bool
     */
    public function isPublic()
    {
        return $this->getAccess() == "public";
    }

    /**
     * @param string $path
     * @param string $type
     * @return bool
     */
    abstract public function matchRoute($path, $type);
}

