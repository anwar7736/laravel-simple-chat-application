<style>
    .user:hover {
        background-color: #f8f9fa;
        transition: 0.2s;
    }

    /* Adjust badge size for smaller screens */
    @media (max-width: 576px) { /* Mobile */
        .pending-badge {
            font-size: 10px;
            padding: 3px 6px;
        }
    }
</style>

<li class="user list-group-item d-flex align-items-center gap-3 p-3 border rounded shadow-sm"
    id="{{ $user->id }}">

    {{-- User Image & Pending Badge --}}
    <div class="d-flex align-items-center position-relative">
        <img src="{{ $user->profile_image_url }}" alt="User Image"
            class="rounded-circle border border-danger object-fit-cover"
            style="width: 40px; height: 40px;">

        @if($user->unread->count() > 0)
            <span class="pending pending-badge badge bg-danger rounded-pill position-absolute translate-middle"
                style="top: 0; right: -10px;">
                {{ $user->unread->count() }}
            </span>
        @endif
    </div>

    {{-- User Info --}}
    <div class="flex-grow-1 overflow-hidden">
        <p class="mb-0 fw-semibold text-truncate" style="max-width: 200px;">{{ $user->name }}</p>
        <p class="mb-0 text-muted text-truncate" style="max-width: 200px;">{{ $user->email }}</p>
    </div>
</li>
