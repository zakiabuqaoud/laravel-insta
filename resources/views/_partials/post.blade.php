@php
$post->increment('views_count')
@endphp
<div class="posty mb-5">
    <div class="post-bar no-margin">
        <div class="post_topbar">
            <div class="usy-dt">
                <img height="30" src="{{ $post->user->profile->avatar_url }}" alt="">
                <div class="usy-name">
                    <h3>{{ $post->user->profile->full_name }}</h3>
                    <span><img src="{{ asset('front/images/clock.png') }}" alt="">{{ $post->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="ed-opts">
                <a href="#" title="" class="ed-opts-open"><i class="la la-ellipsis-v"></i></a>
                <ul class="ed-options">
                    <li><a href="{{ route('posts.edit', [$post->id]) }}" title="">Edit Post</a></li>
                    <li>
                        <form action="{{ route('posts.destroy', [$post->id]) }}" method="post" class="form-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-link">Delete</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="epi-sec">
            <ul class="descp">
                <li><img src="{{ asset('front/images/icon8.png') }}" alt=""><span>Epic Coder</span></li>
                <li><img src="{{ asset('front/images/icon9.png') }}" alt=""><span>India</span></li>
            </ul>
            <ul class="bk-links">
                <li><a href="#" title=""><i class="la la-bookmark"></i></a></li>
                <li><a href="#" title=""><i class="la la-envelope"></i></a></li>
            </ul>
        </div>
        <div class="job_descp">
            <h3>Senior Wordpress Developer</h3>
            <ul class="job-dt">
                <li><a href="#" title="">Full Time</a></li>
                <li><span>$30 / hr</span></li>
            </ul>
            @if($post->media)
            <div class="mb-2">
                <img class="border p-1 rounded" src="{{ asset('storage/' . $post->media) }}">
            </div>
            @endif
            <p>
                {{ $post->content }}
                <a href="#" title="">view more ({{ $post->tags_count }})</a></p>
            <ul class="skill-tags">
                @foreach($post->tags as $tag)
                <li><a href="#" title="">{{ $tag->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="job-status-bar">
            <ul class="like-com">
                <li>
                    <a href="{{ route('likes.store') }}" data-like-id="{{ $post->id }}" data-like-type="post"><i class="fas fa-heart"></i> Like</a>
                    <img src="{{ asset('front/images/liked-img.png') }}" alt="">
                    <span>{{ $post->likes()->count() }}</span>
                </li>
                <li><a href="#" class="com"><i class="fas fa-comment-alt"></i> Comment {{ $post->comments_count }}</a></li>
            </ul>
            <a href="#"><i class="fas fa-eye"></i>Views {{ $post->views_count }}</a>
        </div>
    </div>
    <div class="comment-section">
        <a href="#" class="plus-ic">
            <i class="la la-plus"></i>
        </a>
        <div class="comment-sec">
            <ul class="comments-list-{{ $post->id }}">
                @foreach ($post->comments()->with('user')->latest()->take(2)->get() as $comment)
                <li>
                    <div class="comment-list">
                        <div class="bg-img">
                            <img src="{{ asset('front/images/resources/bg-img3.png') }}" alt="">
                        </div>
                        <div class="comment">
                            <h3>{{ $comment->user->name }}</h3>
                            <span><img src="{{ asset('front/images/clock.png') }}" alt=""> {{ $comment->created_at->diffForHumans() }}</span>
                            <p>{{ $comment->content }}</p>
                            <a href="{{ route('likes.store') }}" data-like-id="{{ $comment->id }}" data-like-type="comment"><i class="fas fa-heart"></i> Like</a>
                            <span>{{ $comment->likes()->count() }}</span>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="post-comment">
            <div class="cm_img">
                <img src="{{ asset('front/images/resources/bg-img4.png') }}" alt="">
            </div>
            <div class="comment_box">
                <form method="post" action="{{ route('comments.store') }}">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="text" name="content" placeholder="Post a comment">
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>