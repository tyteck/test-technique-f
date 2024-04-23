<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Exceptions\AddingMinifiedUrlHasFailed;

class Minifier
{
    protected string $table = 'urls';

    public function __construct(protected Database $db)
    {
        // code
    }

    public static function prepare(Database $db)
    {
        return new static($db);
    }

    public function add(string $alias, string $url): bool
    {
        if (strlen($alias) <= 0) {
            throw new \InvalidArgumentException('Alias is required.');
        }

        if (filter_var($url, FILTER_SANITIZE_URL) === false) {
            throw new \InvalidArgumentException('Url have forbidden characters.');
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('Url is required and must be a valid one.');
        }

        try {
            $this->db->query('INSERT INTO ' . $this->table . '(alias, url) VALUES(:alias, :url)', [
                'alias' => $alias,
                'url'   => $url,
            ]);
        } catch (\Throwable $thrown) {
            throw new AddingMinifiedUrlHasFailed($thrown->getMessage());
        }

        return true;
    }

    public function get(): array
    {
        return array_map(
            fn ($item) => $this->transform($item),
            $this->db->query('select * from ' . $this->table)->get()
        );
    }

    public function find(string $alias): array|bool
    {
        return $this->db->query('select * from ' . $this->table . ' where alias = :alias', [
            'alias' => $alias,
        ])->find();
    }

    protected function transform(array $item): array
    {
        return [
            'alias' => $item['alias'],
            'url'   => $item['url'],
        ];
    }
}
