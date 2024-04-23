<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Container;
use App\Core\Database;

define('BASE_PATH', __DIR__ . '/');

require_once BASE_PATH . 'app/helpers.php';
$config  = require_once BASE_PATH . 'config.php';

dd($_ENV, $_SERVER, getenv());
$_SERVER['APP_ENV'] ?: 'local';

$environment = 'local';
if (isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] === 'testing') {
    $environment = 'testing';
}

App::setEnvironment($environment);

$container = new Container();
$container->singleton(Database::class, fn () => new Database($config[$environment]['db_dsn']));
App::setContainer($container);
