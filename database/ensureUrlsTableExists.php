<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Database;

$db    = App::resolve(Database::class);

$query = <<<'EOT'
SELECT name 
FROM sqlite_master
WHERE type='table' 
    AND name='urls';
EOT;
$result = $db->query($query)->get();

if (count($result) <= 0) {
    $query = <<<'EOT'
    CREATE TABLE IF NOT EXISTS urls (
        id INTEGER NOT NULL PRIMARY KEY ,
        alias TEXT NOT NULL UNIQUE,
        url TEXT NOT NULL
    );
    EOT;
    $err = $db->query($query);

    $query = <<<'EOT'
    INSERT INTO urls (alias,url) VALUES('alias1',	'http://www.something1.com'),
        ('alias2',	'http://www.something2.com'),
        ('alias3',	'http://www.something3.com'),
        ('alias4',	'http://www.something4.com');
    EOT;
    $err = $db->query($query);

    $query = <<<'EOT'
    SELECT * FROM urls;
    EOT;
    $urls = $db->query($query)->get();
}
