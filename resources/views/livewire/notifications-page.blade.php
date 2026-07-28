<div class="p-4">
    <h3 class="mb-4">🔔 All Notifications</h3>

    @if ($notifications->isEmpty())
        <p class="text-muted">No notifications yet.</p>
    @else
        <div class="list-group">
            @foreach ($notifications as $notification)
                <div class="list-group-item">
                    <strong>{{ $notification->title }}</strong>
                    <br>
                    <small class="text-muted">
                        Added by {{ $notification->user_name }} —
                        {{ $notification->created_at->diffForHumans() }}
                    </small>
                </div>
            @endforeach
        </div>
    @endif
</div>
