<?php

namespace Shadowlab\Interfaces\Route;

/**
 * Interface RouteInterface
 * @package Shadowlab\Interfaces\Route
 */
interface Route
{
    /**
     * @param string $path
     * @param string $type
     * @return bool
     */
    public function matchRoute($path, $type);

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
}