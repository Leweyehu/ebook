<?php
// app/Events/UserTyping.php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class UserTyping implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $user;
    public $receiverId;

    public function __construct(User $user, $receiverId)
    {
        $this->user = $user;
        $this->receiverId = $receiverId;
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->receiverId);
    }

    public function broadcastAs()
    {
        return 'UserTyping';
    }
}