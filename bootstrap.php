<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Container;
use App\Core\Database;
use Tests\BaseTestCase;

define('BASE_PATH', __DIR__ . '/');

require_once BASE_PATH . 'app/helpers.php';
$config  = require_once BASE_PATH . 'config.php';

$environment = 'local';
if (BaseTestCase::$testing) {
    $environment = 'testing';
}

$container = new Container();
$container->singleton(Database::class, fn () => new Database($config[$environment]['db_dsn']));
App::setContainer($container);

require_once BASE_PATH . 'database/ensureUrlsTableExists.php';
