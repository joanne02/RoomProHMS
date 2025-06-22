@extends('admin.admin_dashboard')

@section('admin')
<div class="container py-4">
    <h2 class="mb-4">All Notifications</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">
            Showing your last {{ $daysLimit }} days of notifications
        </span>
        <a href="{{ route('notifications.clear') }}" class="btn btn-sm btn-outline-primary">
            Clear All
        </a>
    </div>

    @if ($notifications->count())
        <div class="list-group">
            @foreach ($notifications as $notification)
                <a href="{{ route('notifications.read', $notification->id) }}"
                   class="list-group-item list-group-item-action {{ is_null($notification->read_at) ? 'list-group-item-light' : '' }}">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">
                            {{ $notification->data['title'] ?? 'Notification' }}
                        </h6>
                        <small class="text-muted">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <p class="mb-1">
                        {{ $notification->data['message'] ?? 'You have a new notification.' }}
                    </p>
                </a>
            @endforeach
        </div>
    @else
        <div class="alert alert-info mt-4">
            You have no notifications in the last {{ $daysLimit }} days.
        </div>
    @endif
</div>
@endsection
