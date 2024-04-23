<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class BaseTestCase extends TestCase
{
    public static bool $testing = false;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::$testing = true;
        require_once __DIR__ . '/../bootstrap.php';
    }
}
