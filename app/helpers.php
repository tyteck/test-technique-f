<?php

declare(strict_types=1);

use Symfony\Component\VarDumper\Caster\ScalarStub;
use Symfony\Component\VarDumper\VarDumper;

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

if (!function_exists('dump')) {
    /**
     * @author Nicolas Grekas <p@tchwork.com>
     * @author Alexandre Daubois <alex.daubois@gmail.com>
     */
    function dump(mixed ...$vars): mixed
    {
        if (!$vars) {
            VarDumper::dump(new ScalarStub('🐛'));

            return null;
        }

        if (array_key_exists(0, $vars) && 1 === count($vars)) {
            VarDumper::dump($vars[0]);
            $k = 0;
        } else {
            foreach ($vars as $k => $v) {
                VarDumper::dump($v, is_int($k) ? 1 + $k : $k);
            }
        }

        if (1 < count($vars)) {
            return $vars;
        }

        return $vars[$k];
    }
}

if (!function_exists('dd')) {
    function dd(mixed ...$vars): never
    {
        if (!\in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) && !headers_sent()) {
            header('HTTP/1.1 500 Internal Server Error');
        }

        if (array_key_exists(0, $vars) && 1 === count($vars)) {
            VarDumper::dump($vars[0]);
        } else {
            foreach ($vars as $k => $v) {
                VarDumper::dump($v, is_int($k) ? 1 + $k : $k);
            }
        }

        exit(1);
    }
}
