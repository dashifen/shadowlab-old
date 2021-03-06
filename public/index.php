<?php
session_start();

$path = realpath(__DIR__ . "/../");
require_once($path . "/vendor/autoload.php");

$runner = new League\BooBoo\Runner();
$runner->pushFormatter(new League\BooBoo\Formatter\HtmlTableFormatter);
$runner->register();

$config = function() use ($path) { return require $path . "/config.php"; };
$configuration = $config();

$builder = new \Aura\Di\ContainerBuilder();
$di = $builder->newInstance(["config" => $config], $configuration["config_classes"]);
$dispatcher = $di->newInstance('Shadowlab\Dispatcher\Dispatcher');
$dispatcher->dispatch();