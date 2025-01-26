<style>
    /* Chat Wrapper */
    .chat-box {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 10px;
        max-height: 80vh;
        /* overflow-y: auto; */
    }

    /* Chat Message Container */
    .chat-message {
        display: flex;
        align-items: flex-end;
        max-width: 80%;
    }

    /* Sent Message Alignment */
    .sent {
        align-self: flex-end;
        flex-direction: row-reverse;
    }

    /* Received Message Alignment */
    .received {
        align-self: flex-start;
    }

    /* Chat Bubble */
    .chat-bubble {
        padding: 10px 15px;
        border-radius: 15px;
        max-width: 100%;
        word-wrap: break-word;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    /* Sent Messages (WhatsApp/Messenger Blue) */
    .sent .chat-bubble {
        background-color: #0078ff;
        color: white;
        border-bottom-right-radius: 3px;
    }

    /* Received Messages (Light Gray) */
    .received .chat-bubble {
        background-color: #f1f0f0;
        color: black;
        border-bottom-left-radius: 3px;
    }

    /* Timestamp */
    .chat-bubble .timestamp {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.8);
        display: block;
        margin-top: 5px;
        text-align: right;
    }

    .received .chat-bubble .timestamp {
        color: rgba(0, 0, 0, 0.6);
    }

    /* Profile Image */
    .chat-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #ddd;
        margin: 0 10px;
    }

    /* Mobile Responsive */
    @media (max-width: 576px) {
        .chat-message {
            max-width: 90%;
        }
        .chat-bubble {
            font-size: 14px;
        }
        .chat-img {
            width: 35px;
            height: 35px;
        }
    }
</style>

<ul class="chat-box">
    @foreach($messages as $message)
        <li class="chat-message d-flex {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
            {{-- Profile Image --}}
            <img src="{{ $message->sender->profile_image_url }}" alt="User Image" class="chat-img">
            
            {{-- Chat Bubble --}}
            <div class="chat-bubble">
                <p class="mb-1">{{ $message->message }}</p>
                <span class="timestamp">{{ date('h:i A', strtotime($message->created_at)) }}</span>
            </div>
        </li>
    @endforeach
</ul>
