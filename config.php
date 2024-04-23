<?php

declare(strict_types=1);

return [
    'local' => [
        'db_dsn'  => 'sqlite:' . BASE_PATH . 'database/database.sqlite',
    ],
    // I failed to separate the testing and local $environment
    // so I'm using same DSN
    'testing' => [
        // 'db_dsn'  => 'sqlite::memory:',
        'db_dsn'  => 'sqlite:' . BASE_PATH . 'database/database.sqlite',
    ],
];
