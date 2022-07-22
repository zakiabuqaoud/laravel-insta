<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Rules\ContentRule;
use App\Services\OpenWeatherMap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['password.confirm'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$posts = Post::with('user.profile', 'comments', 'tags')
             ->withCount('tags')->latest()->get();*/

        /*
        SELECT * FROM posts
        WHERE user_id = 1
        OR user_id IN (
            SELECT follower_id FROM followers WHERE following_id = 1
        )
        */
        $user = Auth::user();
        $posts = Post::where('user_id', '=', $user->id)
            ->orWhere(function($query) use ($user) {
                $query->where('visibility', '<>', 'me')
                ->whereRaw('user_id IN (
                    SELECT follower_id FROM followers WHERE following_id = ?
                )', [$user->id]);
            })
            ->with('user.profile', 'comments', 'tags')
            ->withCount('tags')->latest()->get();
             
        return view('posts.index', compact('posts'));

        // SELECT * from posts
        // SELECT * from users where id IN (1, 2)
        // SELECT * from comments where post_id IN (...)
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', [
            'post' => new Post,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request);
        $validator->validate();
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            //abort(500, 'Validation error!');
        }
        

        /*$post = new Post();
        $post->content = $request->post('content');
        $post->save();*/

        $data = $request->except('media');

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            if ($file->isValid()) {
                $data['media'] = $file->store('media', 'public');
            }
        }

        $img = Image::make(storage_path('app/public/' . $data['media']));
        $img->text('Instagram', 20, $img->height() - 20, function($font) {
            $font->file(storage_path('app/arial.ttf'));
            $font->size(26);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('top');
            $font->angle(45);
        })->save();

        $user = Auth::user();
        // $user_id = Auth::id();
        // $user = $request->user();
        $data['user_id'] = $user->id;

        $post = Post::create($data);
        $this->saveTags($post);

        
        //$request->content
        //$request->get('content')
        //$request->input('content')

        //$request->post('content') // Valid only with POST, PUT, PATC
        //$request->query('content') // Valid only wuth GET

        return redirect()->route('posts.index')->with('status', 'Post created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return __METHOD__;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        /*if ($post == null) {
            abort(404);
        }*/
        return view('posts.edit', compact('post'));
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
        $post = Post::findOrFail($id);

        //$request->validate([]);
        //$this->validate($request, []);
        $this->validator($request)->validate();

        /*$post->content = $request->input('content');
        $post->save();*/

        $post->update( $request->all() );
        $this->saveTags($post);

        return redirect()->route('posts.index')->with('status', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::where('id', '=', $id)->delete();
        return redirect()->route('posts.index')->with('status', 'Post deleted!');
        //$post = Post::find($id);
        //$post->delete();
    }

    public function trash()
    {
        return view('posts.index', [
            'posts' => Post::onlyTrashed()->get(),
        ]);
    }

    public function restore(Request $request, $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.index')->with('status', 'Post restored');
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->forceDelete();

        return redirect()->route('posts.index')->with('status', 'Post deleted permanently');
    }

    protected function validator($request)
    {
        /*$request->validate([
            'content' => 'required|min:10|max:255|string',
            'image' => ['required', 'image', 'max:1024', 'dimensions:max_height=500,max_width=800'],
        ]);*/

        return Validator::make($request->all(), [
            'content' => [
                'required', 
                'string', 
                'min:10', 
                'max:255',
                'content:god,allah',
                //new ContentRule(['god', 'allah', 'laravel'])
                /*function($attribute, $value, $fail) {
                    if (strpos($value, 'god') !== false) {
                        $fail('You can not use this word "god"');
                    }
                }*/
            ],

            'media' => ['nullable', 'image', 'max:2048', 'dimensions:max_height=2048,max_width=2048'],
        ], [
            'content.required' => 'الحقل :attribute مطلوب.',
            'min' => 'القيمة أقل من :min',
        ]);
    }

    protected function saveTags($post)
    {
        $tag_ids = [];
        preg_match_all('/\#([^\s]+)/', $post->content, $matches);
        if ($matches) {
            $tags = $matches[1];
            foreach ($tags as $tag_name) {
                /*$tag = Tag::where('name', $tag_name)->first();
                if (!$tag) {
                    $tag = Tag::create([
                        'name' => $tag_name,
                    ]);
                }*/
                $tag = Tag::firstOrCreate([
                    'name' => $tag_name,
                ], []);
                $tag_ids[] = $tag->id;
            }

            $post->tags()->sync($tag_ids);
        }
    }
}
