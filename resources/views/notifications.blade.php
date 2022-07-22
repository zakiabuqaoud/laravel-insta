<x-front-layout>
        <h2>Notifications</h2>
        @foreach($notifications as $notification)
        <div class="notfication-details {{ $notification->unread()? 'bg-info' : 'bg-white' }}">
            <div class="noty-user-img">
                <img src="{{ $notification->data['image'] }}" alt="">
            </div>
            <div class="notification-info">
                <h3><a href="{{ route('notifications.show', [$notification->id]) }}">{{ $notification->data['body'] }}</a></h3>
                <span>{{ $notification->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @endforeach
        {{ $notifications->links() }}
</x-front-layout>