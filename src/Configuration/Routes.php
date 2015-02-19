<?php

namespace Shadowlab\Configuration;

use Aura\Di\Config;
use Aura\Di\Container;
use Shadowlab\Router\Route\PostRoute;
use Shadowlab\Router\Route\GetRoute;

class Routes extends Config
{
    public function define(Container $di)
    {
        $temp = [];

        // because the Dependencies object is configured first, we can use our DI container here
        // to grab an instance of our Database object.  with it we can grab the routes for this
        // app out of the database.

        /*$db = $di->newInstance('Shadowlab\Database\Database');
        $routes = $db->getResults(['type','path','action'], 'routes');


        foreach($routes as $route) {
            $type = array_shift($route);

            // each route requires either the get or post type.  we have two different objects
            // to handle these routes which we instantiate here.

            $temp[] = $type == 'POST'
                ? new PostRoute(...$route)
                : new GetRoute(...$route);
        }*/

        // now that we've accumulated our routes, we will tell our DI container how to construct
        // our Router object.  we tell it all about the $_SERVER superglobal so that we have a local
        // version of that array within the object which ensures that the $_SERVER information is
        // not accidentally changed within it.

        $di->params['\Shadowlab\Router\Router'] = [
            'server' => $_SERVER,
            'routes' => $temp
        ];
    }
}
