<?php

declare(strict_types=1);

namespace App\Enums;

enum HttpVerb: string
{
    case get    = 'GET';
    case post   = 'POST';
    case delete = 'DELETE';
    case put    = 'PUT';
    case patch  = 'PATCH';
}
