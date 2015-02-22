<?php

namespace Shadowlab\Interfaces\Route;

/**
 * Class AbstractRoute
 * @package Shadowlab\Interfaces\Route
 */
abstract class AbstractRoute implements Route
{
    /**
     * @var string
     */
    protected $action = '';
    /**
     * @var string
     */
    protected $access = '';
    /**
     * @var string
     */
    protected $path   = '';

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

    abstract public function matchRoute($path, $type);
}