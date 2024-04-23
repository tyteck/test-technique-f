<?php

declare(strict_types=1);

namespace App\Core;

class Database
{
    public \PDO $connection;

    public \PDOStatement $statement;

    public function __construct(public string $dsn = 'sqlite::memory:')
    {
        $this->connection = new \PDO($dsn);
    }

    public function query($query, $params = []): self
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    public function get(): array
    {
        return $this->statement->fetchAll();
    }

    public function find(): mixed
    {
        return $this->statement->fetch();
    }
}
