<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'likeable_id' => 'required',
            'likeable_type' => 'required|in:comment,post'
        ]);

        if ($request->post('likeable_type') == 'comment') {
            $likeable = Comment::findOrFail($request->post('likeable_id'));
        } else {
            $likeable = Post::findOrFail($request->post('likeable_id'));
        }

        $user = Auth::user();
        DB::table('likes')->insert([
            'user_id' => $user->id,
            'likeable_id' => $likeable->id,
            'likeable_type' => get_class($likeable),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return [
            'message' => 'liked',
        ];
    }
}
