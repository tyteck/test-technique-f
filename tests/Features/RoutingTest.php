<?php

declare(strict_types=1);

namespace Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Tests\Features\FeaturesTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class RoutingTest extends FeaturesTestCase
{
    /** @test */
    public function it_should_return_404(): void
    {
        $client = new Client();
        $uri    = self::BASE_URL . '/unknown';

        try {
            $response = $client->request('GET', $uri);
            $this->fail("request to {$uri} should result in 404.");
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
            $this->assertEquals(404, $response->getStatusCode());

            $data = json_decode($response->getBody()->getContents(), true);

            array_map(fn ($key) => $this->assertArrayHasKey($key, $data), ['status', 'message', 'data']);

            $this->assertEqualsCanonicalizing([
                'status'  => 'error',
                'message' => 'Page not found',
                'data'    => [],
            ], $data);
        }
    }

    /**
     * @dataProvider provideValidEndpoints
     */
    public function test_should_return_200(string $verb, string $endpoint): void
    {
        $client   = new Client();
        $uri      = self::BASE_URL . $endpoint;
        $response = $client->request($verb, $uri);

        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody()->getContents(), true);
        array_map(fn ($key) => $this->assertArrayHasKey($key, $data), ['status', 'data']);
    }

    /** @test */
    public function it_should_call_right_controller(): void
    {
        $client   = new Client();
        $uri      = self::BASE_URL . '/urls';
        $response = $client->request('GET', $uri);

        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody()->getContents(), true);

        array_map(fn ($key) => $this->assertArrayHasKey($key, $data), ['status', 'data']);
    }

    /*
    |--------------------------------------------------------------------------
    | helpers & providers
    |--------------------------------------------------------------------------
    */
    public static function provideValidEndpoints(): array
    {
        return [
            'index (GET)'      => ['GET', '/urls'],
            'show (GET)'       => ['GET', '/urls/show'],
            'store (POST)'     => ['POST', '/urls'],
            'update (PATCH)'   => ['PATCH', '/urls'],
            'destroy (DELETE)' => ['DELETE', '/urls'],
        ];
    }
}
