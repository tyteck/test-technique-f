<?php

declare(strict_types=1);

use App\Core\Container;
use App\Core\Database;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ContainerTest extends TestCase
{
    /** @test */
    public function it_should_throw_exception(): void
    {
        $container = new Container();

        $this->expectException(RuntimeException::class);
        $container->resolve('unknown');
    }

    /** @test */
    public function bind_variable_should_work_properly(): void
    {
        $container = new Container();
        $container->bind('lorem', 'ipsum');
        $this->assertSame('ipsum', $container->resolve('lorem'));
    }

    /** @test */
    public function bind_closure_should_work_properly(): void
    {
        $container = new Container();
        $container->bind('dolore', fn () => 'sit amet');

        $this->assertSame('sit amet', $container->resolve('dolore'));
    }

    /** @test */
    public function bind_object_should_work_properly(): void
    {
        $container = new Container();
        $container->bind(stdClass::class, fn () => new stdClass());

        $result = $container->resolve(stdClass::class);
        $this->assertInstanceOf(stdClass::class, $result);
    }

    /** @test */
    public function singleton_should_work_properly_with_class(): void
    {
        $container = new Container();
        $dsn       = 'sqlite:' . BASE_PATH . 'database/database.sqlite';
        $container->singleton(Database::class, fn () => new Database($dsn));

        $object1 = $container->resolve(Database::class);
        $object2 = $container->resolve(Database::class);
        $this->assertSame($object1, $object2);
    }
}
