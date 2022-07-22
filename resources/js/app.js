const { default: Echo } = require('laravel-echo');

require('./bootstrap');

require('alpinejs');

window.Echo.private('Notifications.' + userId)
    .notification((notification) => {
        alert(notification.body);
    });

window.Echo.private('PostActivity.' + userId)
    .listen('.NewComment', (data) => {
        //alert(data.comment.content);
        console.log(data);
        jQuery(`.comments-list-${data.comment.post_id}`).append(`<li>
        <div class="comment-list">
            <div class="bg-img">
                <img src="${data.user.profile.avatar_url}" alt="">
            </div>
            <div class="comment">
                <h3>${data.user.name}</h3>
                <span><img src="/front/images/clock.png" alt=""> ${data.comment.created_at}</span>
                <p>${data.comment.content}</p>
                <a href="#" title=""><i class="fa fa-reply-all"></i>Reply</a>
            </div>
        </div>
    </li>`);
    });