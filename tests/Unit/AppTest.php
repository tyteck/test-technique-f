<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\App;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class AppTest extends TestCase
{
    /** @test */
    public function environment_should_work_properly(): void
    {
        App::setEnvironment('lorem');
        $this->assertEquals('lorem', App::environment());
    }

    /** @test */
    public function environment_should_not_be_overrided(): void
    {
        App::setEnvironment('lorem');
        App::setEnvironment('ipsum');
        $this->assertEquals('lorem', App::environment());
    }
}
