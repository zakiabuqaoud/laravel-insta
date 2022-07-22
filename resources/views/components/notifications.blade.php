
    <a href="#" title="" class="not-box-open">
        <span><img src="{{ asset('front/images/icon7.png') }}" alt=""></span>
        Notification
    </a>
    <div class="notification-box noti" id="notification">
        <div class="nt-title">
            <h4>Setting</h4>
            <a href="#" title="">Clear all</a>
        </div>
        <div class="nott-list">
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
            <div class="view-all-nots">
                <a href="{{ route('notifications') }}" title="">View All Notification</a>
            </div>
        </div>
    </div>
