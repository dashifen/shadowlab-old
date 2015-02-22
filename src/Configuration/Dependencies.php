<?php

namespace Shadowlab\Configuration;

use Aura\Di\Container;
use Aura\Di\Config;

class Dependencies extends Config
{
    public function define(Container $di)
    {
        $config = $di->get('config');

        // our $config array comes with a closure to determine if this is the development server or the
        // production one.  we'll use the results of that function to determine which database credentials
        // are necessary for the application at this time.

        $isDevelopment = $config["isDevelopment"];

        $dbconfig = !$isDevelopment()
            ? $config["database"]["prod"]
            : $config["database"]["dev"];

        $di->params['mysqli'] = [
            'host'     => $dbconfig['host'],
            'user'     => $dbconfig['user'],
            'password' => $dbconfig['pass'],
            'database' => $dbconfig['name'],
            'port'     => $dbconfig['port'],
            'socket'   => ''
        ];

        $di->params['Shadowlab\Database\Database'] = [
            'db' => $di->lazyNew('mysqli')
        ];

        $di->params['Shadowlab\Dispatcher\Dispatcher'] = [
            'container' => $di,
            'response'  => $di->lazyNew('Aura\Web\Response'),
            'session'   => $di->lazyNew('Shadowlab\Session\Session'),
            'router'    => $di->lazyNew('Shadowlab\Router\Router')
        ];

        $di->params['Shadowlab\Pages\Page'] = [
            'header' => $di->lazyNew('Shadowlab\Pages\Files\File', ['file' => $config['layout']['header']]),
            'footer' => $di->lazyNew('Shadowlab\Pages\Files\File', ['file' => $config['layout']['footer']]),
        ];






    }
}




