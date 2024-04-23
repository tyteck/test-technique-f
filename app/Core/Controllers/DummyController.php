<?php

declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\Router;

class DummyController
{
    public function index(): int
    {
        header(header: 'Content-Type: application/json');
        echo json_encode([
            'status'  => 'success',
            'message' => 'Do not become crazy, it works !',
            'data'    => [],
        ]);

        return Router::STATUS_SUCCESSFUL;
    }
}
