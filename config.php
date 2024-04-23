<?php

declare(strict_types=1);

return [
    'local' => [
        'db_dsn'  => 'sqlite:' . BASE_PATH . 'database/database.sqlite',
    ],
    'testing' => [
        'db_dsn'  => 'sqlite::memory:',
    ],
];
