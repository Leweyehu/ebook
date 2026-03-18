import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// Add CSRF token to all axios requests
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] =
        token.getAttribute("content");
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

// Add Authorization header if user has a token
const authToken = localStorage.getItem("auth_token");
if (authToken) {
    window.axios.defaults.headers.common[
        "Authorization"
    ] = `Bearer ${authToken}`;
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo";
import Pusher from "pusher-js";

// Make Pusher available globally
window.Pusher = Pusher;

// Get the environment variables for Reverb
const reverbKey = import.meta.env.VITE_REVERB_APP_KEY;
const reverbHost = import.meta.env.VITE_REVERB_HOST ?? "localhost";
const reverbPort = import.meta.env.VITE_REVERB_PORT ?? 8080;
const reverbScheme = import.meta.env.VITE_REVERB_SCHEME ?? "http";
const reverbWsPort = reverbScheme === "https" ? 443 : reverbPort;

// Initialize Echo with Reverb configuration
window.Echo = new Echo({
    broadcaster: "reverb",
    key: reverbKey,
    wsHost: reverbHost,
    wsPort: reverbPort,
    wssPort: reverbWsPort,
    forceTLS: reverbScheme === "https",
    enabledTransports: ["ws", "wss"],
    disableStats: true,

    // Add authentication for private channels
    authEndpoint: "/broadcasting/auth",
    auth: {
        headers: {
            "X-CSRF-TOKEN": token?.getAttribute("content"),
        },
    },
});

// Optional: Log Echo connection status for debugging
if (import.meta.env.MODE === "development") {
    window.Echo.connector.pusher.connection.bind("connected", () => {
        console.log("✅ Connected to Reverb WebSocket server");
    });

    window.Echo.connector.pusher.connection.bind("disconnected", () => {
        console.log("❌ Disconnected from Reverb WebSocket server");
    });

    window.Echo.connector.pusher.connection.bind("error", (error) => {
        console.error("⚠️ Reverb WebSocket error:", error);
    });
}

// Helper function to get current user ID from meta tag
function getCurrentUserId() {
    const userIdMeta = document.querySelector('meta[name="user-id"]');
    return userIdMeta ? userIdMeta.getAttribute("content") : null;
}

// Helper function to join user's private channel when logged in
export function joinUserChannel(userId) {
    if (!userId) return null;

    const channel = window.Echo.private(`user.${userId}`);

    channel.listen(".message.sent", (event) => {
        console.log("New message received:", event);

        // Dispatch a custom event that your Vue/React components can listen to
        window.dispatchEvent(
            new CustomEvent("new-message", {
                detail: event,
            })
        );
    });

    channel.listen(".message.read", (event) => {
        console.log("Message read:", event);
        window.dispatchEvent(
            new CustomEvent("message-read", {
                detail: event,
            })
        );
    });

    channel.listen(".user.typing", (event) => {
        console.log("User typing:", event);
        window.dispatchEvent(
            new CustomEvent("user-typing", {
                detail: event,
            })
        );
    });

    channel.listen(".user.online", (event) => {
        console.log("User online:", event);
        window.dispatchEvent(
            new CustomEvent("user-online", {
                detail: event,
            })
        );
    });

    channel.listen(".user.offline", (event) => {
        console.log("User offline:", event);
        window.dispatchEvent(
            new CustomEvent("user-offline", {
                detail: event,
            })
        );
    });

    return channel;
}

// Helper function to join conversation channel
export function joinConversationChannel(conversationId) {
    if (!conversationId) return null;

    const channel = window.Echo.private(`conversation.${conversationId}`);

    channel.listen(".message.new", (event) => {
        console.log("New message in conversation:", event);
        window.dispatchEvent(
            new CustomEvent("conversation-message", {
                detail: event,
            })
        );
    });

    channel.listen(".message.updated", (event) => {
        console.log("Message updated:", event);
        window.dispatchEvent(
            new CustomEvent("message-updated", {
                detail: event,
            })
        );
    });

    channel.listen(".message.deleted", (event) => {
        console.log("Message deleted:", event);
        window.dispatchEvent(
            new CustomEvent("message-deleted", {
                detail: event,
            })
        );
    });

    channel.listen(".conversation.read", (event) => {
        console.log("Conversation marked as read:", event);
        window.dispatchEvent(
            new CustomEvent("conversation-read", {
                detail: event,
            })
        );
    });

    return channel;
}

// Auto-join user channel when page loads if user is logged in
document.addEventListener("DOMContentLoaded", () => {
    const userId = getCurrentUserId();
    if (userId) {
        joinUserChannel(userId);
    }
});

// Helper function to update user online status
export function updateUserStatus(status = "online") {
    if (!window.userId) return;

    window.axios
        .post("/api/user/status", { status })
        .then((response) => {
            console.log("Status updated:", response.data);
        })
        .catch((error) => {
            console.error("Failed to update status:", error);
        });
}

// Set user as online when page loads, offline when page unloads
document.addEventListener("DOMContentLoaded", () => {
    if (window.userId) {
        updateUserStatus("online");
    }
});

window.addEventListener("beforeunload", () => {
    if (window.userId) {
        // Use synchronous request to ensure it completes before page unloads
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/api/user/status", false); // false makes it synchronous
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", token?.getAttribute("content"));
        xhr.send(JSON.stringify({ status: "offline" }));
    }
});

// Export Echo instance and helpers
export default window.Echo;
