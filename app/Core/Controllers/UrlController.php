<?php

declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\App;
use App\Core\Database;
use App\Core\Router;
use App\Services\Minifier;

class UrlController
{
    protected Database $db;

    public function __construct()
    {
        header(header: 'Content-Type: application/json');
        $this->db = App::resolve(Database::class);
    }

    public function index(): int
    {
        try {
            echo json_encode([
                'status' => 'success',
                'data'   => Minifier::prepare($this->db)->get(),
            ]);

            return Router::STATUS_SUCCESSFUL;
        } catch (\Throwable $thrown) {
            // should log something somewhere and notify someone
            return Router::STATUS_FAILURE;
        }
    }

    public function show(string $alias): int
    {
        try {
            $url = Minifier::prepare($this->db)->find($alias);
            echo json_encode([
                'status' => 'success',
                'url'    => 'https://www.facebook.com',
            ]);

            return Router::STATUS_SUCCESSFUL;
        } catch (\Throwable $thrown) {
            // should log something somewhere and notify someone
            return Router::STATUS_FAILURE;
        }
    }

    public function store(string $alias): int
    {
        try {
            echo json_encode([
                'status' => 'success',
                'url'    => 'https://www.facebook.com',
            ]);

            return Router::STATUS_SUCCESSFUL;
        } catch (\Throwable $thrown) {
            // should log something somewhere and notify someone
            return Router::STATUS_FAILURE;
        }
    }
}
