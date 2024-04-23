<?php

declare(strict_types=1);

namespace Tests\Features;

use App\Core\App;
use App\Core\Database;
use PHPUnit\Framework\TestCase;
use Tests\Traits\RefreshDatabase;

/**
 * @internal
 *
 * @coversNothing
 */
class FeaturesTestCase extends TestCase
{
    use RefreshDatabase;

    protected const BASE_URL = 'http://localhost';

    protected Database $db;

    protected function setUp(): void
    {
        parent::setUp();

        // exit('FTC : ' . $_SERVER['APP_ENV']);
        $this->db = App::resolve(Database::class);
        $this->createTableIfNotExists();

        $results = $this->db->query('select count(*) as nb from urls')->get();
        $this->assertEquals(0, $results[0]['nb']);
    }

    public function tearDown(): void
    {
        $this->dropTableUrls();
        parent::tearDown();
    }
}
