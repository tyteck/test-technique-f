<?php

declare(strict_types=1);

namespace Tests\Features\Core;

use App\Core\Database;
use Tests\Features\FeaturesTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class DatabaseTest extends FeaturesTestCase
{
    public function tearDown(): void
    {
        $this->cleanTableUrls();
        parent::tearDown();
    }

    /** @test */
    public function it_should_instanciate(): void
    {
        $this->assertNotNull($this->db);
        $this->assertInstanceOf(Database::class, $this->db);
    }

    /** @test */
    public function it_should_insert(): void
    {
        $query = <<<'EOT'
        INSERT INTO urls (alias,url) 
        VALUES('alias',	'http://www.something.com');
        EOT;
        $result = $this->db->query($query);

        $query = <<<'EOT'
        select * from urls
        EOT;
        $results = $this->db->query($query)->get();
        $this->assertNotNull($results);
        $this->assertIsArray($results);
        $this->assertCount(1, $results);
    }
}
