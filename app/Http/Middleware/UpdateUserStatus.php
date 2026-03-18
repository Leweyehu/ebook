<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserStatus;
use App\Events\UserOnline;

class UpdateUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Update or create user status
            $status = UserStatus::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'status' => 'online',
                    'last_seen_at' => now()
                ]
            );
            
            // Broadcast that user is online
            try {
                broadcast(new UserOnline($user))->toOthers();
            } catch (\Exception $e) {
                // Log error but don't break the request
                \Log::error('Broadcast error: ' . $e->getMessage());
            }
        }
        
        return $next($request);
    }
}