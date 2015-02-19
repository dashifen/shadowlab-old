<?php
session_start();

$path = realpath(__DIR__ . "/../");
require_once($path . "/vendor/autoload.php");

$runner = new Savage\BooBoo\Runner();
$runner->pushFormatter(new Savage\BooBoo\Formatter\HtmlTableFormatter);
$runner->register();

$config = function() use ($path) { return require $path . "/config.php"; };
$configuration = $config();

$x=1;

$di_container_builder = new \Aura\Di\ContainerBuilder();
$di = $di_container_builder->newInstance(["config" => $config], $configuration["config_classes"], \Aura\Di\ContainerBuilder::DISABLE_AUTO_RESOLVE);

$db = $di->newInstance('Shadowlab\Database\Database');

var_dump($db);

//$dispatcher = $di->newInstance('Shadowlab\Dispatcher\Dispatcher');
//$dispatcher->dispatch();