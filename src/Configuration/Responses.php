<?php

namespace Shadowlab\Configuration;

use Aura\Di\Container;
use Aura\Di\Config;

class Responses extends Config
{
    public function define(Container $di)
    {
        $di->params['Shadowlab\Interfaces\Response\AbstractResponse'] = [
            'view'     => $di->lazyNew('Aura\View\View'),
            'request'  => $di->lazyNew('Aura\Web\Request'),
            'response' => $di->lazyNew('Aura\Web\Response'),
        ];


    }
}
