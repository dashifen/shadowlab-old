<?php

namespace Shadowlab\Router\Route;

/**
 * Interface RouteInterface
 * @package Shadowlab\Interfaces\Routes
 */
interface RouteInterface {
    /**
     * @param string$path
     * @param string $type
     * @return bool
     */
    public function matchRoute($path, $type);

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
    public function getAccess();

    /**
     * @return bool
     */
    public function isPublic();
}
