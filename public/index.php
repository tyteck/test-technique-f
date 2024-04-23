<?php

declare(strict_types=1);

use App\Core\Router;
use App\Enums\HttpVerb;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap.php';

$parsedUri = parse_url($_SERVER['REQUEST_URI']);
$path      = $parsedUri['path'];
$method    = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$queries = [];
parse_str($parsedUri['query'] ?? '', $queries);

$router = Router::init();
require base_path('routes/api.php');

try {
    $verb = HttpVerb::from($method);
    $router->route($path, $verb, $queries);
} catch (Throwable $thrown) {
    header(header: 'Content-Type: application/json', response_code: $thrown->getCode());
    echo json_encode([
        'status'  => 'error',
        'message' => $thrown->getMessage(),
        'data'    => [],
    ]);
}
