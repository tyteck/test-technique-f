<?php

declare(strict_types=1);

if (!function_exists('base_path')) {
    function base_path($path)
    {
        return BASE_PATH . trim($path, DIRECTORY_SEPARATOR);
    }
}

if (!function_exists('database_path')) {
    function database_path($path)
    {
        return base_path('database' . DIRECTORY_SEPARATOR . $path);
    }
}
