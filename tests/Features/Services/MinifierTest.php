<?php

declare(strict_types=1);

namespace Tests\Features\Services;

use App\Exceptions\AddingMinifiedUrlHasFailed;
use App\Services\Minifier;
use Tests\Features\FeaturesTestCase;
use Tests\Traits\RefreshDatabase;

/**
 * @internal
 *
 * @coversNothing
 */
class MinifierTest extends FeaturesTestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider provideInvalidInputs
     *
     * @test
     */
    public function it_should_fail_without_proper_url(string $alias, string $url): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Minifier::prepare($this->db)->add($alias, $url);
    }

    /**
     * @dataProvider provideValidInputs
     *
     * @test
     */
    public function it_should_add_minified_url(string $alias, string $url): void
    {
        $result = Minifier::prepare($this->db)->add($alias, $url);
        $this->assertTrue($result);

        $rows = $this->db->query('select * from urls')->get();
        $this->assertNotNull($rows);
        $this->assertIsArray($rows);
        $this->assertCount(1, $rows);
    }

    /** @test */
    public function it_should_get_retrieve_all_minified_urls(): void
    {
        $minifier = Minifier::prepare($this->db);
        $minifier->add('alias1', 'https://www.lorem.com');
        $minifier->add('alias2', 'https://www.ipsum.fr');
        $results = $minifier->get();

        $this->assertNotNull($results);
        $this->assertIsArray($results);
        $this->assertCount(2, $results);

        foreach ($results as $minifiedItem) {
            $this->assertEqualsCanonicalizing(['alias', 'url'], array_keys($minifiedItem));
        }
    }

    /** @test */
    public function it_should_fail_when_adding_existing_alias(): void
    {
        $minifier = Minifier::prepare($this->db);
        $minifier->add('alias1', 'https://www.lorem.com');
        $this->expectException(AddingMinifiedUrlHasFailed::class);
        $minifier->add('alias1', 'https://www.ipsum.com');
    }

    /** @test */
    public function it_should_return_false_when_alias_not_found(): void
    {
        $result = Minifier::prepare($this->db)->find('lorem');
        $this->assertNotNull($result);
        $this->assertFalse($result);
    }

    /** @test */
    public function it_should_return_row_when_alias_exists(): void
    {
        $minifier = Minifier::prepare($this->db);
        $minifier->add('lorem', 'https://www.lorem.com');
        $result = $minifier->find('lorem');
        $this->assertNotNull($result);
        $this->assertIsArray($result);
        $this->assertEquals('lorem', $result['alias']);
        $this->assertEquals('https://www.lorem.com', $result['url']);
    }

    /*
    |--------------------------------------------------------------------------
    | helpers & providers
    |--------------------------------------------------------------------------
    */
    public static function provideInvalidInputs(): array
    {
        return [
            'both empty'      => ['', ''],
            'alias empty'     => ['', 'www.google.com'],
            'url empty'       => ['lorem', ''],
            'url not an url'  => ['lorem', 'not an url'],
            'forbidden chars' => ['lorem', 'www.g**gle.com'],
            'no protocol'     => ['fb', 'www.facebook.com'],
        ];
    }

    public static function provideValidInputs(): array
    {
        return [
            'https'          => ['google', 'https://www.google.com'],
            'http'           => ['fb', 'http://www.facebook.com'],
        ];
    }
}
