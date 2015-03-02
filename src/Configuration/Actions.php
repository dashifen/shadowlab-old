<?php

namespace Shadowlab\Configuration;

use Aura\Di\Container;
use Aura\Di\Config;

class Actions extends Config
{
    public function define(Container $di)
    {
        $di->params['Shadowlab\Dispatcher\Dispatcher'] = [
            'container' => $di,
            'response'  => $di->lazyNew('Shadowlab\Responses\Blank'),
            'session'   => $di->lazyNew('Shadowlab\Session\Session'),
            'router'    => $di->lazyNew('Shadowlab\Router\Router')
        ];

        $di->params['Shadowlab\Interfaces\Action\AbstractAction'] = [
            'http'    => $di->lazyNew('Shadowlab\Responses\Blank'),
            'session' => $di->lazyNew('Shadowlab\Session\Session'),
            'request' => $di->lazyNew('Aura\Web\Request')
        ];

        $di->params['Shadowlab\Actions\User\LoginAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Login')
        ];

        $di->params['Shadowlab\Actions\User\AuthenticateAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Login')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\IndexAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Index')
        ];
    }
}
