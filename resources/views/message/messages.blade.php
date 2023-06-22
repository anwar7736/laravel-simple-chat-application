<div class="message-wrapper">
    <ul class="messages">
        @forelse($messages as $message)
        @include('message.message', compact('message') )
        @empty
        <div align="center">
            <strong class="text-danger">
                No messages are available
            </strong>
        </div>
        @endforelse
    </ul>
</div>

<div class="input-text">
    <input type="text" name="message" id="message" class="submit" placeholder="Write something...">
</div>