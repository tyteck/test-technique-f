<?php

declare(strict_types=1);

namespace Tests\Traits;

trait RefreshDatabase
{
    public function createTableIfNotExists(): void
    {
        $query = <<<'EOT'
        CREATE TABLE IF NOT EXISTS urls (
            id INTEGER NOT NULL PRIMARY KEY ,
            alias TEXT NOT NULL UNIQUE,
            url TEXT NOT NULL
        );
        EOT;
        $this->db->query($query);
    }

    public function cleanTableUrls(): void
    {
        $query = <<<'EOT'
        DELETE FROM urls;
        EOT;

        $this->db->query($query);
    }

    public function dropTableUrls(): void
    {
        $query = <<<'EOT'
        DROP TABLE IF EXISTS urls;
        EOT;

        $this->db->query($query);
    }
}
