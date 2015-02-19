<?php

namespace Shadowlab\Router\Route;

class PostRoute extends AbstractRoute
{
    public function matchRoute($path, $type)
    {
        return $type == "POST" && $this->path == $path;
    }
}
