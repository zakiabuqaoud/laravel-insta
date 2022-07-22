<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user->tokenCan('posts')) {
            return Post::with('user.profile')->paginate(2);
        }

        return response()->json([
            'message' => 'Unauthorized',
        ], 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string'],
            'media' => ['nullable', 'image'],
        ]);

        $request->merge([
            'user_id' => 1,
        ]);

        $post = Post::create($request->all());

        //return response()->json($post, 201);
        return new JsonResponse($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return $post->load('user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => ['sometimes', 'required', 'string'],
            'media' => ['nullable', 'image'],
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        //return response()->json($post, 201);
        return new JsonResponse([
            'message' => 'Post updated',
            'data' => $post,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return [
            'message' => 'Posts deleted',
        ];
    }
}
