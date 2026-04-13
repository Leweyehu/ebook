<?php

// Set base path for Laravel
$basePath = __DIR__ . '/../';

// Load Composer autoloader
require $basePath . 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once $basePath . 'bootstrap/app.php';

// Handle the request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();
$kernel->terminate($request, $response);