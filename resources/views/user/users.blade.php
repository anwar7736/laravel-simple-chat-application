<ul class="users">
    @forelse($users as $key => $user)
    @if($user->id != Auth::id())
        @include('user.user', compact('user'))
    @endif
    @empty
    <div align="center">
        <strong class="text-danger">
            No users are available
        </strong>
    </div>
    @endforelse
</ul>