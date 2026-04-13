<?php

// Set base path for Laravel
$basePath = __DIR__ . '/../';

// Use Vercel's writable /tmp directory
$tmpPath = '/tmp/laravel-storage';

// Create storage directories in /tmp
$directories = [
    $tmpPath,
    $tmpPath . '/logs',
    $tmpPath . '/framework',
    $tmpPath . '/framework/cache',
    $tmpPath . '/framework/sessions',
    $tmpPath . '/framework/views'
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Override storage path before Laravel boots
putenv("APP_STORAGE_PATH={$tmpPath}");
putenv("LARAVEL_STORAGE_PATH={$tmpPath}");

// Load Composer autoloader
require $basePath . 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once $basePath . 'bootstrap/app.php';

// Force the storage path after bootstrapping
$app->useStoragePath($tmpPath);

// Handle the request
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    
    $response->send();
    $kernel->terminate($request, $response);
} catch (Exception $e) {
    http_response_code(500);
    echo "Application Error: " . $e->getMessage();
    error_log('Laravel Vercel Error: ' . $e->getMessage());
}