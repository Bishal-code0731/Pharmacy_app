@extends('layouts.pharmacy')

@section('content')
<div class="notifications-page">
    <h2>Your Notifications</h2>
    
    <div class="notification-list">
        @forelse($notifications as $notification)
            <div class="notification-item {{ $notification->unread() ? 'unread' : '' }}">
                <div class="notification-content">
                    {{ $notification->data['message'] ?? 'Notification' }}
                </div>
                <div class="notification-meta">
                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                    @if($notification->unread())
                        <a href="{{ route('notifications.read', $notification->id) }}" 
                           class="mark-as-read">Mark as read</a>
                    @endif
                </div>
            </div>
        @empty
            <p>No notifications found.</p>
        @endforelse
        
        {{ $notifications->links() }}
    </div>
</div>
@endsection