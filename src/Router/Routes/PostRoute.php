<?php

namespace Shadowlab\Router\Routes;

use Shadowlab\Interfaces\Route\AbstractRoute;

/**
 * Class PostRoute
 * @package Shadowlab\Router\Routes
 */
class PostRoute extends AbstractRoute
{
    public function __construct($path, $action, $access)
    {
        parent::__construct($path, $action, $access);
        $this->method = "POST";
    }
}
