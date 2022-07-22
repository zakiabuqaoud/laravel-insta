<?php

namespace App\Http\Controllers;

use App\Events\NewComment;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'post_id' => 'required|exists:posts,id',
        ]);

        $user = $request->user();

        /*$post = Post::findOrFail($request->post('post_id'));
        $post->comments()->create([
            'user_id' => $user->id,
            'content' => $request->post('content')
        ]);*/

        $comment = $user->comments()->create([
            'post_id' => $request->post('post_id'),
            'content' => $request->post('content')
        ]);
        $comment->post->increment('comments_count');

        /*$comment = Comment::create([
            'post_id' => $request->post('post_id'),
            'user_id' => $user->id,
            'content' => $request->post('content')
        ]);*/
        
        event(new NewComment($comment));

        return redirect()->back()->with('status', 'Comment added');
    }
}
