<?php

// Force all paths to use /tmp (Vercel's writable directory)
$tmpPath = '/tmp/laravel';

// Create all necessary directories in /tmp
$directories = [
    $tmpPath,
    $tmpPath . '/storage',
    $tmpPath . '/storage/framework',
    $tmpPath . '/storage/framework/cache',
    $tmpPath . '/storage/framework/sessions',
    $tmpPath . '/storage/framework/views',
    $tmpPath . '/storage/logs',
    $tmpPath . '/bootstrap',
    $tmpPath . '/bootstrap/cache'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Set environment variables for storage paths
putenv("APP_STORAGE_PATH={$tmpPath}/storage");
putenv("LARAVEL_STORAGE_PATH={$tmpPath}/storage");

// Define constants for Laravel
if (!defined('LARAVEL_STORAGE_PATH')) {
    define('LARAVEL_STORAGE_PATH', $tmpPath . '/storage');
}

// Load Composer
$basePath = __DIR__ . '/../';
require $basePath . 'vendor/autoload.php';

// Create app instance
$app = require_once $basePath . 'bootstrap/app.php';

// Force override storage path
$app->useStoragePath($tmpPath . '/storage');

// Ensure log directory is writable
$logFile = $tmpPath . '/storage/logs/laravel.log';
if (!file_exists($logFile)) {
    file_put_contents($logFile, '');
}

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
    error_log('Laravel Error: ' . $e->getMessage());
}