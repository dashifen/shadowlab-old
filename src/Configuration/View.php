<?php
namespace Shadowlab\Configuration;

use Aura\Di\Container;
use Aura\Di\Config;

class View extends Config
{
    public function define(Container $di)
    {
        $di->params['Aura\View\View'] = array(
            'view_registry'   => $di->lazyNew('Aura\View\TemplateRegistry'),
            'layout_registry' => $di->lazyNew('Aura\View\TemplateRegistry'),
            'helpers'         => $di->lazyNew('Aura\View\HelperRegistry'),
        );
    }

    public function modify(Container $di)
    {
    }
}
