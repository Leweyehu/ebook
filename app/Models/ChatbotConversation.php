<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatbotConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_ip',
        'user_message',
        'bot_response',
        'intent',
        'is_helpful'
    ];

    protected $casts = [
        'is_helpful' => 'boolean',
        'created_at' => 'datetime'
    ];
}