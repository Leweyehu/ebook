<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::middleware(['auth:sanctum'])->prefix('chat')->group(function () {
    Route::get('/online-users', [ChatController::class, 'onlineUsers']);
    Route::get('/messages/{userId}', [ChatController::class, 'messages']);
    Route::post('/messages', [ChatController::class, 'sendMessage']);
    Route::post('/conversations', [ChatController::class, 'createConversation']);
    Route::post('/typing', [ChatController::class, 'typing']);
});