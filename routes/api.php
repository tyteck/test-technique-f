<?php

declare(strict_types=1);

use App\Core\Controllers\DummyController;
use App\Core\Controllers\UrlController;
use App\Enums\HttpVerb;

$router->add(HttpVerb::get, '/urls', UrlController::class, 'index')
    ->add(HttpVerb::get, '/urls/show', UrlController::class, 'show')
    ->add(HttpVerb::post, '/urls', UrlController::class, 'store')
    ->add(HttpVerb::patch, '/urls', UrlController::class, 'update')
    ->add(HttpVerb::delete, '/urls', UrlController::class, 'destroy')
    ->add(HttpVerb::get, '/', DummyController::class, 'index')
;
