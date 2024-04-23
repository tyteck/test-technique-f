<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Router;
use App\Enums\HttpVerb;
use App\Exceptions\PageNotFound;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class RouterTest extends TestCase
{
    /** @test */
    public function it_should_return_routes(): void
    {
        $routes = Router::init()
            ->add(HttpVerb::get, 'urls/show', 'urlController', 'show')
            ->add(HttpVerb::get, 'urls', 'urlController', 'index')
            ->add(HttpVerb::post, 'urls', 'urlController', 'store')
            ->add(HttpVerb::patch, 'urls', 'urlController', 'update')
            ->add(HttpVerb::delete, 'urls', 'urlController', 'destroy')
            ->routes()
        ;
        $this->assertNotNull($routes);
        $this->assertIsArray($routes);
        $this->assertCount(5, $routes);
    }

    /** @test */
    public function it_should_throw_exception_when_not_found(): void
    {
        $this->expectException(PageNotFound::class);
        Router::init()->route('/unknown');
    }
}
