<?php

namespace Shadowlab\Configuration;

use Aura\Di\Container;
use Aura\Di\Config;

class Services extends Config
{
    public function define(Container $di)
    {
        $di->params['Shadowlab\Services\UserService'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\User\UserFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\User\UserFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\User\UserGateway'),
            'payload' => $di->lazyNew('Shadowlab\Domains\User\PayloadFactory')
        ];
    }
}
