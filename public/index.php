<?php

use App\Config\Config;
use App\Dispatcher\RouteDispatcher;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotEnv = Dotenv::createImmutable(__DIR__ . '/..');
$dotEnv->load();

Config::init();

$requestUri = $_SERVER['REQUEST_URI'];

RouteDispatcher::dispatch($requestUri);
