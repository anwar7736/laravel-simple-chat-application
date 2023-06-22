<li class="message clearfix">
    {{--if message from id is equal to auth id then it is sent by logged in user --}}
    <div class="{{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
        <div class="row">
        @if($message->sender_id == Auth::id())          
        <div class="col-md-9">
            <p>{{ $message->message }}</p>
            <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
            <small>{{ $message->sender->name }}</small>
        </div>
        <div class="col-md-3">
             <img src="{{ $message->sender->image }}" alt="" height="30" width="30" style="border-radius:50%">
        </div>  
        </div>
        @else
        <div class="col-md-3">
             <img src="{{ $message->sender->image }}" alt="" height="30" width="30" style="border-radius:50%">
            </div>            
            <div class="col-md-9">
            <p>{{ $message->message }}</p>
        <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
        <small>{{ $message->sender->name }}</small>
            </div>
        </div>
        @endif

    </div>
</li>