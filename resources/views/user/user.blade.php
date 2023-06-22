<li class="user" id="{{ $user->id }}">
     @if($user->unread->count() > 0)
        <span class="pending">{{ $user->unread->count() }}</span>
     @endif
    <div class="media">
        <div class="media-left">
            <img src="{{ $user->image }}" alt="" class="media-object">
        </div>

        <div class="media-body">
            <p class="name">{{ $user->name }}</p>
            <p class="email">{{ $user->email }}</p>
        </div>
    </div>
</li>