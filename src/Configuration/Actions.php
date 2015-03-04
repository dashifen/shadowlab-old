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

        $di->params['Shadowlab\Actions\Cheatsheets\IndexCombatAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexCombat')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\IndexMagicAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexMagic')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\IndexMatrixAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexMatrix')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\MatrixActionsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActions'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\MatrixActions')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\IndexOtherAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexOther')
        ];
    }
}
