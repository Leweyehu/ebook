@extends('layouts.app')

@section('title', 'Chat Assistant')

@section('content')
<style>
    .chatbot-container {
        max-width: 1000px;
        margin: 2rem auto;
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 90vh;
        transition: all 0.3s ease;
    }
    
    .chatbot-header {
        background: linear-gradient(135deg, #003E72 0%, #1c5a8a 100%);
        color: white;
        padding: 1rem;
        text-align: center;
        position: relative;
        flex-shrink: 0;
    }
    
    .chatbot-header h2 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .chatbot-header h2 i {
        font-size: 1.5rem;
        animation: pulse 2s infinite;
    }
    
    .chatbot-header p {
        margin: 0.3rem 0 0;
        opacity: 0.95;
        font-size: 0.8rem;
    }
    
    .chatbot-header .status-badge {
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        background: #28a745;
        color: white;
        padding: 0.2rem 0.6rem;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 600;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    
    /* CHAT MESSAGES - TALLER TO SHOW MORE LINES */
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        min-height: 0;
    }
    
    /* Custom Scrollbar */
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }
    
    .chat-messages::-webkit-scrollbar-track {
        background: #e2e8f0;
        border-radius: 3px;
    }
    
    .chat-messages::-webkit-scrollbar-thumb {
        background: #ffc107;
        border-radius: 3px;
    }
    
    .message {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        animation: fadeInUp 0.3s ease;
        max-width: 100%;
    }
    
    .message.user {
        flex-direction: row-reverse;
        align-self: flex-end;
    }
    
    .message.bot {
        align-self: flex-start;
    }
    
    .message-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .message.bot .message-avatar {
        background: linear-gradient(135deg, #ffc107, #ffed4a);
        color: #003E72;
    }
    
    .message.user .message-avatar {
        background: linear-gradient(135deg, #003E72, #1c5a8a);
        color: white;
    }
    
    .message-avatar i {
        font-size: 1.1rem;
    }
    
    /* MESSAGE CONTENT - NO HEIGHT RESTRICTIONS */
    .message-content {
        padding: 0.8rem 1rem;
        border-radius: 18px;
        line-height: 1.5;
        font-size: 0.9rem;
        word-wrap: break-word;
        white-space: pre-wrap;
        max-width: 85%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        overflow: visible;
        height: auto;
    }
    
    /* Bot Message Styling */
    .message.bot .message-content {
        background: white;
        color: #1e293b;
        border-bottom-left-radius: 5px;
        border: 1px solid #e2e8f0;
        font-size: 0.9rem;
        line-height: 1.5;
    }
    
    /* Bot Message Content Formatting */
    .message.bot .message-content strong {
        color: #003E72;
        font-weight: 700;
        font-size: 0.95rem;
    }
    
    .message.bot .message-content ul, 
    .message.bot .message-content ol {
        margin: 0.3rem 0;
        padding-left: 1.2rem;
    }
    
    .message.bot .message-content li {
        margin-bottom: 0.2rem;
        line-height: 1.5;
    }
    
    .message.bot .message-content p {
        margin-bottom: 0.4rem;
        line-height: 1.5;
    }
    
    .message.bot .message-content br {
        display: block;
        margin-bottom: 0.2rem;
        content: "";
    }
    
    .message.user .message-content {
        background: linear-gradient(135deg, #ffc107, #ffed4a);
        color: #003E72;
        border-bottom-right-radius: 5px;
        font-weight: 500;
        padding: 0.6rem 1rem;
    }
    
    /* Bullet Points Styling */
    .message.bot .message-content ul li {
        position: relative;
        list-style-type: none;
        padding-left: 1rem;
        margin-bottom: 0.2rem;
    }
    
    .message.bot .message-content ul li:before {
        content: "•";
        color: #ffc107;
        font-weight: bold;
        font-size: 0.9rem;
        position: absolute;
        left: 0;
        top: 0;
    }
    
    /* Typing Indicator */
    .typing-indicator {
        display: flex;
        gap: 4px;
        padding: 0.5rem 0.8rem;
        background: white;
        border-radius: 20px;
        width: fit-content;
        border: 1px solid #e2e8f0;
    }
    
    .typing-indicator span {
        width: 6px;
        height: 6px;
        background: #ffc107;
        border-radius: 50%;
        animation: typing 1.4s infinite;
    }
    
    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
    
    /* Suggestions Section */
    .suggestions {
        padding: 0.6rem 0.8rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        flex-shrink: 0;
    }
    
    .suggestion-btn {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 0.4rem 0.8rem;
        border-radius: 40px;
        font-size: 0.7rem;
        cursor: pointer;
        transition: all 0.3s;
        color: #334155;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .suggestion-btn i {
        font-size: 0.7rem;
    }
    
    .suggestion-btn:hover {
        background: #ffc107;
        color: #003E72;
        border-color: #ffc107;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Input Area */
    .chat-input-area {
        padding: 0.8rem;
        background: white;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 0.6rem;
        align-items: center;
        flex-shrink: 0;
    }
    
    .chat-input-wrapper {
        flex: 1;
        position: relative;
    }
    
    .chat-input {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        font-size: 0.85rem;
        transition: all 0.3s;
        background: #f8fafc;
        resize: none;
        font-family: 'Inter', sans-serif;
    }
    
    .chat-input:focus {
        outline: none;
        border-color: #ffc107;
        background: white;
        box-shadow: 0 0 0 3px rgba(255,193,7,0.1);
    }
    
    .send-btn {
        background: linear-gradient(135deg, #ffc107, #ffed4a);
        color: #003E72;
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        flex-shrink: 0;
    }
    
    .send-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255,193,7,0.4);
        background: linear-gradient(135deg, #ffed4a, #ffc107);
    }
    
    .send-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); opacity: 0.5; }
        30% { transform: translateY(-6px); opacity: 1; }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    /* Scroll to bottom button */
    .scroll-btn {
        position: fixed;
        bottom: 90px;
        right: 20px;
        background: #ffc107;
        color: #003E72;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.3s;
        z-index: 100;
        border: none;
    }
    
    .scroll-btn:hover {
        transform: scale(1.1);
        background: #ffed4a;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .chatbot-container {
            height: 92vh;
            margin: 0.5rem;
            border-radius: 20px;
        }
        
        .message-content {
            max-width: 90%;
            font-size: 0.85rem;
            padding: 0.6rem 0.8rem;
        }
        
        .message.bot .message-content {
            font-size: 0.85rem;
        }
        
        .message-avatar {
            width: 30px;
            height: 30px;
        }
        
        .message-avatar i {
            font-size: 0.9rem;
        }
        
        .chatbot-header h2 {
            font-size: 1.2rem;
        }
        
        .suggestions {
            padding: 0.5rem;
        }
        
        .suggestion-btn {
            padding: 0.3rem 0.6rem;
            font-size: 0.65rem;
        }
        
        .chat-input {
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
        }
        
        .send-btn {
            width: 34px;
            height: 34px;
            font-size: 0.8rem;
        }
        
        .chat-messages {
            padding: 0.8rem;
        }
    }
    
    @media (max-width: 480px) {
        .chatbot-container {
            height: 95vh;
            margin: 0.3rem;
        }
        
        .chatbot-header {
            padding: 0.6rem;
        }
        
        .chatbot-header h2 {
            font-size: 1rem;
        }
        
        .message-content {
            max-width: 95%;
            font-size: 0.8rem;
            padding: 0.5rem 0.7rem;
        }
        
        .suggestion-btn {
            font-size: 0.6rem;
            padding: 0.2rem 0.5rem;
        }
    }
</style>

<div class="chatbot-container">
    <div class="chatbot-header">
        <h2>
            <i class="fas fa-robot"></i>
            CS Department Assistant
        </h2>
        <p>Your guide to Computer Science at Mekdela Amba University</p>
        <div class="status-badge">
            <i class="fas fa-circle" style="font-size: 0.6rem;"></i> Online
        </div>
    </div>
    
    <div class="chat-messages" id="chatMessages">
        <div class="message bot">
            <div class="message-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="message-content">
                <strong>👋 Hello! I'm your CS Department Assistant</strong><br><br>
                I'm here to help you explore everything about Computer Science at Mekdela Amba University! 🎓<br><br>
                
                <strong>✨ You can ask me about:</strong><br>
                📚 <strong>Benefits of studying CS</strong> - Why it's a great choice<br>
                💼 <strong>Career opportunities</strong> - Jobs and career paths<br>
                🚀 <strong>Future prospects</strong> - Emerging technologies<br>
                📖 <strong>What you'll learn</strong> - Skills and knowledge<br>
                🎓 <strong>Our programs</strong> - Degrees and courses<br>
                📝 <strong>Admission</strong> - How to join us<br>
                👨‍🏫 <strong>Staff & faculty</strong> - Who teaches you<br>
                🌟 <strong>Alumni success</strong> - Where graduates work<br>
                💼 <strong>Internships</strong> - Practical experience<br>
                📚 <strong>Study tips</strong> - How to succeed<br><br>
                
                <strong>💡 Just type your question below and I'll help you!</strong><br>
                ✨ Example: "Why study computer science?" or "What career opportunities are there?"
            </div>
        </div>
    </div>
    
    <div class="suggestions">
        <button class="suggestion-btn" onclick="sendSuggestion('Why study computer science?')">
            <i class="fas fa-question-circle"></i> Why Study CS?
        </button>
        <button class="suggestion-btn" onclick="sendSuggestion('What career opportunities?')">
            <i class="fas fa-briefcase"></i> Career Opportunities
        </button>
        <button class="suggestion-btn" onclick="sendSuggestion('What are the benefits?')">
            <i class="fas fa-gem"></i> Benefits
        </button>
        <button class="suggestion-btn" onclick="sendSuggestion('What will I learn?')">
            <i class="fas fa-book"></i> Skills
        </button>
        <button class="suggestion-btn" onclick="sendSuggestion('Future prospects in CS')">
            <i class="fas fa-chart-line"></i> Future Prospects
        </button>
        <button class="suggestion-btn" onclick="sendSuggestion('Admission requirements')">
            <i class="fas fa-graduation-cap"></i> Admission
        </button>
        <button class="suggestion-btn" onclick="sendSuggestion('Tell me about staff')">
            <i class="fas fa-chalkboard-teacher"></i> Staff
        </button>
        <button class="suggestion-btn" onclick="sendSuggestion('Alumni success stories')">
            <i class="fas fa-star"></i> Alumni
        </button>
        <button class="suggestion-btn" onclick="sendSuggestion('Internship opportunities')">
            <i class="fas fa-building"></i> Internship
        </button>
        <button class="suggestion-btn" onclick="sendSuggestion('Study tips for CS')">
            <i class="fas fa-lightbulb"></i> Study Tips
        </button>
    </div>
    
    <div class="chat-input-area">
        <div class="chat-input-wrapper">
            <textarea 
                id="userInput" 
                class="chat-input" 
                placeholder="Type your question here... (Press Enter to send)"
                rows="1"
                onkeypress="handleKeyPress(event)"
                style="resize: none; overflow-y: hidden;"
            ></textarea>
        </div>
        <button id="sendBtn" class="send-btn" onclick="sendMessage()">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<button class="scroll-btn" id="scrollToBottomBtn" onclick="scrollToBottom()" style="display: none;">
    <i class="fas fa-arrow-down"></i>
</button>

<script>
    let isProcessing = false;
    const messagesDiv = document.getElementById('chatMessages');
    const scrollBtn = document.getElementById('scrollToBottomBtn');
    
    // Auto-resize textarea
    const textarea = document.getElementById('userInput');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 80) + 'px';
    });
    
    function handleKeyPress(event) {
        if (event.key === 'Enter' && !event.shiftKey && !isProcessing) {
            event.preventDefault();
            sendMessage();
        }
    }
    
    function sendSuggestion(text) {
        document.getElementById('userInput').value = text;
        sendMessage();
    }
    
    function scrollToBottom() {
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
    
    function checkScroll() {
        const isNearBottom = messagesDiv.scrollHeight - messagesDiv.scrollTop - messagesDiv.clientHeight < 100;
        scrollBtn.style.display = isNearBottom ? 'none' : 'flex';
    }
    
    messagesDiv.addEventListener('scroll', checkScroll);
    
    function sendMessage() {
        const input = document.getElementById('userInput');
        const message = input.value.trim();
        
        if (!message || isProcessing) return;
        
        isProcessing = true;
        input.disabled = true;
        document.getElementById('sendBtn').disabled = true;
        
        addMessage(message, 'user');
        input.value = '';
        input.style.height = 'auto';
        
        showTypingIndicator();
        
        fetch('{{ route("chatbot.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            removeTypingIndicator();
            if (data.success) {
                let formattedResponse = data.response;
                formattedResponse = formattedResponse.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                formattedResponse = formattedResponse.replace(/• /g, '✨ ');
                formattedResponse = formattedResponse.replace(/\n/g, '<br>');
                addMessage(formattedResponse, 'bot');
            } else {
                addMessage('Sorry, I encountered an error. Please try again.', 'bot');
            }
        })
        .catch(error => {
            removeTypingIndicator();
            addMessage('Sorry, I encountered an error. Please try again.', 'bot');
        })
        .finally(() => {
            isProcessing = false;
            input.disabled = false;
            document.getElementById('sendBtn').disabled = false;
            input.focus();
        });
    }
    
    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}`;
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = sender === 'bot' ? '<i class="fas fa-robot"></i>' : '<i class="fas fa-user"></i>';
        
        const content = document.createElement('div');
        content.className = 'message-content';
        content.innerHTML = text;
        
        messageDiv.appendChild(avatar);
        messageDiv.appendChild(content);
        
        messagesDiv.appendChild(messageDiv);
        scrollToBottom();
    }
    
    function showTypingIndicator() {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'message bot';
        typingDiv.id = 'typingIndicator';
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = '<i class="fas fa-robot"></i>';
        
        const content = document.createElement('div');
        content.className = 'message-content';
        content.innerHTML = '<div class="typing-indicator"><span></span><span></span><span></span></div>';
        
        typingDiv.appendChild(avatar);
        typingDiv.appendChild(content);
        
        messagesDiv.appendChild(typingDiv);
        scrollToBottom();
    }
    
    function removeTypingIndicator() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) {
            indicator.remove();
        }
    }
    
    document.getElementById('userInput').focus();
    
    // Initial scroll to show full message
    setTimeout(() => {
        scrollToBottom();
    }, 100);
</script>
@endsection