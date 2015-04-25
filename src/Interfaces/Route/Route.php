<?php

namespace Shadowlab\Interfaces\Route;

/**
 * Interface RouteInterface
 * @package Shadowlab\Interfaces\Route
 */
interface Route
{
    /**
     * @param Route $route
     * @return bool
     */
    public function matchRoute(Route $route);

    /**
     * @return bool
     */
    public function isPrivate();

    /**
     * @return string
     */
    public function getAccess();

    /**
     * @return string
     */
    public function getAction();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getMethod();
}