<?php

namespace Shadowlab\Configuration;

use Aura\Di\Config;
use Aura\Di\Container;

class View extends Config
{
    protected $root = '';

    public function define(Container $di)
    {
        $this->findUIRoot();

        $di->params['Aura\View\View'] = array(
            'view_registry'   => $di->lazyNew('Aura\View\TemplateRegistry', [ 'map' => $this->findViews()  ]),
            'layout_registry' => $di->lazyNew('Aura\View\TemplateRegistry', [ 'map' => $this->findLayout() ]),
            'helpers'         => $di->lazyNew('Aura\View\HelperRegistry'),
        );
    }

    public function modify(Container $di)
    {

    }

    protected function findUIRoot()
    {
        $root  = '';
        $path  = realpath(__DIR__);
        $parts = explode(DIRECTORY_SEPARATOR, $path);

        foreach ($parts as $part) {
            if($part == 'src') break;
            $root .= $part . DIRECTORY_SEPARATOR;
        }

        $root .= "ui" . DIRECTORY_SEPARATOR;
        $this->root = $root;
    }

    protected function findLayout()
    {
        $layouts = $this->root . "Layouts" . DIRECTORY_SEPARATOR;
        return [ 'cheatsheets' => $layouts . "cheatsheets.php" ];
    }

    protected function findViews()
    {
        $root  = $this->root . "Responses" . DIRECTORY_SEPARATOR;
        $directory = new \RecursiveDirectoryIterator($root);
        $directory->setFlags(\RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($directory);

        $views = [];
        foreach($files as $filename => $file) {
            $filename = substr($filename, 0, strlen($filename)-4);
            $filename = str_replace($root, '', $filename);
            $views[$filename] = $file->getRealPath();
        }

        return $views;
    }
}
