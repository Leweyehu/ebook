<?php

// Set base path for Laravel
$basePath = __DIR__ . '/../';

// Create storage symbolic link programmatically for Vercel
$publicPath = $basePath . 'public/storage';
$storagePath = $basePath . 'storage/app/public';

if (!file_exists($publicPath) && file_exists($storagePath)) {
    try {
        symlink($storagePath, $publicPath);
    } catch (Exception $e) {
        // Log error but continue execution
        error_log('Storage symlink creation failed: ' . $e->getMessage());
    }
}

// Ensure storage directories exist for Vercel's tmp filesystem
$storageDirs = [
    $basePath . 'storage/framework/cache',
    $basePath . 'storage/framework/sessions',
    $basePath . 'storage/framework/views',
    $basePath . 'storage/logs'
];

foreach ($storageDirs as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Load Composer autoloader
require $basePath . 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once $basePath . 'bootstrap/app.php';

// Handle the request with error handling for Vercel environment
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    
    $response->send();
    $kernel->terminate($request, $response);
} catch (Exception $e) {
    // Handle common Vercel deployment errors
    $errorMessage = $e->getMessage();
    
    // Check for specific errors
    if (strpos($errorMessage, 'No application encryption key') !== false) {
        http_response_code(500);
        echo "Application key missing. Please set APP_KEY in environment variables.\n";
        echo "Run 'php artisan key:generate' locally and add the key to Vercel environment variables.";
    } elseif (strpos($errorMessage, 'Connection refused') !== false || strpos($errorMessage, 'database') !== false) {
        http_response_code(500);
        echo "Database connection error. Please check your database credentials in Vercel environment variables.\n";
        echo "Make sure DB_HOST, DB_DATABASE, DB_USERNAME, and DB_PASSWORD are set correctly.";
    } else {
        http_response_code(500);
        echo "Application Error: " . $errorMessage . "\n";
        echo "Check Vercel logs for more details.";
    }
    
    // Log error for debugging
    error_log('Laravel Vercel Error: ' . $errorMessage);
}