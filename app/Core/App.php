<?php

declare(strict_types=1);

namespace App\Core;

class App
{
    protected static Container $container;
    protected static ?string $environment = null;

    public static function setContainer($container): void
    {
        static::$container = $container;
    }

    public static function container()
    {
        return static::$container;
    }

    public static function bind($key, $resolver): void
    {
        static::container()->bind($key, $resolver);
    }

    public static function resolve($key)
    {
        return static::container()->resolve($key);
    }

    public static function setEnvironment(string $environment): void
    {
        if (is_null(static::$environment)) {
            static::$environment = $environment;
        }
    }

    public static function environment(): string
    {
        return static::$environment;
    }
}
