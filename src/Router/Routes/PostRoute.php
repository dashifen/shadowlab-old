<?php

namespace Shadowlab\Router\Routes;

use Shadowlab\Interfaces\Route\AbstractRoute;

/**
 * Class PostRoute
 * @package Shadowlab\Router\Routes
 */
class PostRoute extends AbstractRoute
{
    /**
     * @param string $path
     * @param string $type
     * @return bool
     */
    public function matchRoute($path, $type)
    {
        return $type == "POST" && $path == $this->path;
    }
}
