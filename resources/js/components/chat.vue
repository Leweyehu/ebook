<!-- resources/js/components/Chat.vue -->
<template>
    <div class="chat-container">
        <div class="users-list">
            <h3>Online Users</h3>
            <ul>
                <li v-for="user in onlineUsers" :key="user.id" 
                    @click="selectUser(user)">
                    {{ user.name }}
                    <span v-if="user.role === 'staff'" class="badge">Staff</span>
                    <span v-else class="badge">Student</span>
                </li>
            </ul>
        </div>
        
        <div class="chat-window" v-if="selectedUser">
            <div class="messages">
                <div v-for="message in messages" :key="message.id"
                     :class="message.sender_id === currentUserId ? 'sent' : 'received'">
                    <strong>{{ message.sender_name }}:</strong>
                    <p>{{ message.message }}</p>
                    <small>{{ message.created_at }}</small>
                </div>
            </div>
            
            <div class="typing-indicator" v-if="isTyping">
                {{ selectedUser.name }} is typing...
            </div>
            
            <form @submit.prevent="sendMessage">
                <input type="text" v-model="newMessage" 
                       @keyup="sendTypingIndicator"
                       placeholder="Type your message...">
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            onlineUsers: [],
            selectedUser: null,
            messages: [],
            newMessage: '',
            currentUserId: window.userId,
            isTyping: false,
            typingTimer: null
        }
    },
    
    mounted() {
        this.fetchOnlineUsers();
        this.listenForMessages();
        this.listenForTyping();
    },
    
    methods: {
        async fetchOnlineUsers() {
            const response = await fetch('/chat/api/online-users', {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            });
            this.onlineUsers = await response.json();
        },
        
        selectUser(user) {
            this.selectedUser = user;
            this.fetchMessages(user.id);
            this.joinConversation(user.id);
        },
        
        async fetchMessages(userId) {
            const response = await fetch(`/chat/api/messages/${userId}`);
            this.messages = await response.json();
        },
        
        async sendMessage() {
            if (!this.newMessage.trim()) return;
            
            const response = await fetch('/chat/api/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify({
                    receiver_id: this.selectedUser.id,
                    message: this.newMessage
                })
            });
            
            this.newMessage = '';
        },
        
        listenForMessages() {
            Echo.private(`chat.${this.currentUserId}`)
                .listen('MessageSent', (event) => {
                    if (event.message.sender_id === this.selectedUser?.id) {
                        this.messages.push(event.message);
                    }
                });
        },
        
        listenForTyping() {
            Echo.private(`chat.${this.currentUserId}`)
                .listenForWhisper('typing', (event) => {
                    if (event.user_id === this.selectedUser?.id) {
                        this.isTyping = true;
                        clearTimeout(this.typingTimer);
                        this.typingTimer = setTimeout(() => {
                            this.isTyping = false;
                        }, 3000);
                    }
                });
        },
        
        sendTypingIndicator() {
            if (this.selectedUser) {
                Echo.private(`chat.${this.selectedUser.id}`)
                    .whisper('typing', { user_id: this.currentUserId });
            }
        },
        
        joinConversation(userId) {
            Echo.private(`chat.${this.currentUserId}`)
                .listen('UserOnline', (event) => {
                    // Update online status
                });
        }
    }
}
</script>