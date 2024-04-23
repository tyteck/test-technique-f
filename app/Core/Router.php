<?php

declare(strict_types=1);

namespace App\Core;

use App\Enums\HttpVerb;
use App\Exceptions\PageNotFound;

class Router
{
    public const STATUS_SUCCESSFUL = 200;
    public const STATUS_NOT_FOUND  = 404;
    public const STATUS_FAILURE    = 500;

    protected array $routes = [];

    private function __construct() {}

    public static function init(): static
    {
        return new static();
    }

    public function add(
        HttpVerb $verb,
        string $path,
        string $controller,
        string $function
    ): self {
        $this->routes[] = [
            'path'       => $path,
            'controller' => $controller,
            'verb'       => $verb,
            'function'   => $function,
        ];

        return $this;
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function route(
        string $path,
        HttpVerb $verb = HttpVerb::get,
        array $queries = [],
    ): int {
        foreach ($this->routes as $route) {
            if ($route['path'] === $path && $route['verb'] === $verb) {
                $controller = (new $route['controller']());
                $function   = $route['function'];

                return $controller->{$function}($queries);
            }
        }

        throw new PageNotFound('Page not found', self::STATUS_NOT_FOUND);
    }
}
