<?php

declare(strict_types=1);

namespace Tests\Features\Core;

use App\Services\Minifier;
use GuzzleHttp\Client;
use Tests\Features\FeaturesTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class UrlControllerTest extends FeaturesTestCase
{
    /** @test */
    public function index_should_return_nothing(): void
    {
        $client   = new Client();
        $uri      = self::BASE_URL . '/urls';
        $response = $client->request('GET', $uri);

        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertEquals(200, $response->getStatusCode());

        $json = json_decode($response->getBody()->getContents(), true);

        array_map(fn ($key) => $this->assertArrayHasKey($key, $json), ['status', 'data']);
        $this->assertNotNull($json['data']);
        $this->assertIsArray($json['data']);
        $this->assertEmpty($json['data']);
    }

    /** @test */
    public function index_should_return_urls(): void
    {
        $client   = new Client();
        $uri      = self::BASE_URL . '/urls';
        $response = $client->request('GET', $uri);

        $minifier = Minifier::prepare($this->db);
        $minifier->add('lorem1', 'http://www.lorem.com');

        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertEquals(200, $response->getStatusCode());
        $json = json_decode($response->getBody()->getContents(), true);

        array_map(fn ($key) => $this->assertArrayHasKey($key, $json), ['status', 'data']);
        $this->assertNotNull($json['data']);
        $this->assertIsArray($json['data']);
        $this->assertNotEmpty($json['data']);
    }
}
