<?php

namespace Shadowlab\Configuration;

use Aura\Di\Container;
use Aura\Di\Config;

class Domains extends Config
{
    public function define(Container $di)
    {
        $di->params['Shadowlab\Interfaces\Domain\AbstractGateway'] = [
            'db' => $di->lazyNew('Shadowlab\Database\Database')
        ];

        $di->params['Shadowlab\Interfaces\Domain\AbstractDomain'] = [
            'payload' => $di->lazyNew('Shadowlab\Interfaces\Domain\Payloads\PayloadFactory'),
        ];

        $di->params['Shadowlab\Domains\User\User'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\User\UserFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\User\UserFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\User\UserGateway'),
        ];

        $di->params['Shadowlab\Domains\User\UserFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\User\UserEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Cheatsheets'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\CheatsheetsFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\CheatsheetsFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\CheatsheetsGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\CheatsheetsFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\CheatsheetsEntity')
        ];


        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActions'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActionsFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActionsFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActionsGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActionsFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActionsEntity')
        ];

    }
}
