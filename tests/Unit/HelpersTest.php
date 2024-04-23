<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class HelpersTest extends TestCase
{
    /** @test */
    public function base_path_should_work_properly(): void
    {
        $this->assertEquals('/app/foo', base_path('foo'));
        $this->assertEquals('/app/lorem', base_path('/lorem'));
        $this->assertEquals('/app/lorem/ipsum', base_path('lorem/ipsum/'));
    }

    /** @test */
    public function database_path_should_work_properly(): void
    {
        $this->assertEquals('/app/database/lorem', database_path('lorem'));
    }
}
