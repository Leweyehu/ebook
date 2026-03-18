@extends('layouts.app')

@section('title', 'Chat')
@section('page-title', 'Messages')

@section('content')
<div style="display: grid; grid-template-columns: 350px 1fr; gap: 1.5rem; height: calc(100vh - 200px);">
    <!-- Left Sidebar - Conversations and Online Users -->
    <div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden; display: flex; flex-direction: column;">
        <!-- Tabs -->
        <div style="display: flex; border-bottom: 1px solid #e9ecef;">
            <button id="conversationsTab" class="tab-btn active" onclick="switchTab('conversations')" style="flex: 1; padding: 1rem; background: none; border: none; cursor: pointer; font-weight: 600; color: #667eea; border-bottom: 3px solid #667eea;">Chats</button>
            <button id="onlineTab" class="tab-btn" onclick="switchTab('online')" style="flex: 1; padding: 1rem; background: none; border: none; cursor: pointer; font-weight: 600; color: #666;">Online Users</button>
        </div>

        <!-- Conversations List -->
        <div id="conversationsList" style="flex: 1; overflow-y: auto; padding: 1rem;">
            @forelse($conversations as $conversation)
                @php
                    $otherUser = $conversation->users->where('id', '!=', Auth::id())->first();
                    $lastMessage = $conversation->latestMessage;
                    $unreadCount = $conversation->messages()
                        ->where('user_id', '!=', Auth::id())
                        ->where('is_read', false)
                        ->count();
                @endphp
                <div class="conversation-item" data-id="{{ $conversation->id }}" onclick="loadConversation({{ $conversation->id }})" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border-radius: 10px; cursor: pointer; margin-bottom: 0.5rem; background: #f8f9fa;">
                    <div style="width: 50px; height: 50px; background: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                        {{ substr($otherUser->name ?? 'U', 0, 1) }}
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between;">
                            <strong>{{ $otherUser->name ?? 'Unknown' }}</strong>
                            @if($lastMessage)
                                <span style="font-size: 0.8rem; color: #999;">{{ $lastMessage->created_at->diffForHumans() }}</span>
                            @endif
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #666; font-size: 0.9rem;">{{ Str::limit($lastMessage->message ?? 'No messages', 30) }}</span>
                            @if($unreadCount > 0)
                                <span style="background: #dc3545; color: white; padding: 0.2rem 0.5rem; border-radius: 50%; font-size: 0.7rem;">{{ $unreadCount }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p style="color: #999; text-align: center; padding: 2rem;">No conversations yet. Start chatting with someone!</p>
            @endforelse
        </div>

        <!-- Online Users List (hidden by default) -->
        <div id="onlineUsersList" style="flex: 1; overflow-y: auto; padding: 1rem; display: none;">
            @foreach($allUsers as $user)
                <div class="online-user-item" data-id="{{ $user->id }}" onclick="startConversation({{ $user->id }})" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border-radius: 10px; cursor: pointer; margin-bottom: 0.5rem; background: #f8f9fa;">
                    <div style="position: relative;">
                        <div style="width: 50px; height: 50px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        @if($user->status && $user->status->status === 'online')
                            <span style="position: absolute; bottom: 2px; right: 2px; width: 12px; height: 12px; background: #28a745; border-radius: 50%; border: 2px solid white;"></span>
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <strong>{{ $user->name }}</strong>
                        <div style="color: #666; font-size: 0.8rem;">{{ ucfirst($user->role) }}</div>
                    </div>
                    <i class="fas fa-comment" style="color: #667eea;"></i>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Right Side - Chat Area -->
    <div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden; display: flex; flex-direction: column;">
        <!-- Chat Header -->
        <div id="chatHeader" style="padding: 1rem; border-bottom: 1px solid #e9ecef; background: #f8f9fa; display: none;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 40px; height: 40px; background: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;" id="chatAvatar">U</div>
                <div>
                    <h3 id="chatUserName" style="margin: 0;">Select a conversation</h3>
                    <p id="chatUserStatus" style="margin: 0; font-size: 0.8rem; color: #666;"></p>
                </div>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="messagesArea" style="flex: 1; overflow-y: auto; padding: 1.5rem; display: none;">
            <div style="text-align: center; color: #999; padding: 2rem;" id="noMessages">
                Select a conversation to start chatting
            </div>
            <div id="messagesContainer"></div>
        </div>

        <!-- Typing Indicator -->
        <div id="typingIndicator" style="padding: 0.5rem 1.5rem; color: #666; font-style: italic; display: none;">
            Someone is typing...
        </div>

        <!-- Message Input -->
        <div id="messageInput" style="padding: 1.5rem; border-top: 1px solid #e9ecef; display: none;">
            <form id="messageForm" onsubmit="sendMessage(event)">
                <div style="display: flex; gap: 1rem;">
                    <input type="text" id="messageText" placeholder="Type your message..." style="flex: 1; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                    <button type="submit" style="background: #667eea; color: white; border: none; padding: 0.75rem 2rem; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-paper-plane"></i> Send
                    </button>
                </div>
            </form>
        </div>

        <!-- No Conversation Selected -->
        <div id="noConversation" style="flex: 1; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 1rem;">
            <i class="fas fa-comments" style="font-size: 5rem; color: #e9ecef;"></i>
            <p style="color: #999;">Select a conversation or start a new chat</p>
        </div>
    </div>
</div>

<!-- Include Pusher and Laravel Echo -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.0/dist/echo.iife.js"></script>

<script>
    // Initialize Pusher and Echo
    const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        forceTLS: true,
        authEndpoint: '/broadcasting/auth'
    });

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ env("PUSHER_APP_KEY") }}',
       