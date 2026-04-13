<?php

// Set base path for Laravel
$basePath = __DIR__ . '/../';

// Load Composer autoloader
require $basePath . 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once $basePath . 'bootstrap/app.php';

// Handle the request
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    
    $response->send();
    $kernel->terminate($request, $response);
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    
    if (strpos($errorMessage, 'No application encryption key') !== false) {
        http_response_code(500);
        echo "Application key missing. Please set APP_KEY in environment variables.";
    } elseif (strpos($errorMessage, 'Connection refused') !== false || strpos($errorMessage, 'database') !== false) {
        http_response_code(500);
        echo "Database connection error. Please check your database credentials.";
    } else {
        http_response_code(500);
        echo "Application Error: " . $errorMessage;
    }
    
    error_log('Laravel Vercel Error: ' . $errorMessage);
}