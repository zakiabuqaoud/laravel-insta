<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index($username = null)
    {
        if ($username == null) {
            $user = Auth::user();
        } else {
            $user = User::where('username', '=', $username)->first();
            if (!$user) {
                abort(404);
            }
        }

        return view('profile.index', [
            'user' => $user,
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'first_name' => ['max:255'],
            'last_name' => ['max:255'],
            'birthday' => ['date_format:Y-m-d'],
            'gender' => ['in:male,female'],
            'avatar' => 'image',
            'bio' => 'nullable',
            'hour_rate' => 'nullable|numeric|min:0'
        ]);

        $data = $request->except('avatar');
        $old_avatar = false;;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $data['avatar'] = $file->store('avatars', 'public');
            $old_avatar = $user->profile->avatar;

            $img = Image::make(storage_path('app/public/' . $data['avatar']));
            $img->crop(150, 150)->save();    
        }

        /*if ($user->profile->id) {
            $user->profile->update($data);
        } else {
            $user->profile()->create($data);
        }*/

        Profile::updateOrCreate([
            'user_id' => $user->id,
        ], $data);
        

        if ($old_avatar) {
            Storage::disk('public')->delete($old_avatar);
        }

        return redirect()->route('profile.edit')->with('status', 'Profile updated');
    }

    public function follow(Request $request)
    {
        $request->validate([
            'following_id' => 'required|exists:users,id',
        ]);

        $follower = Auth::user();
        $following_id = $request->post('following_id');
        
        if (!$follower->following($following_id)) {
            $follower->followings()->attach($following_id);
        }

        $following = User::find($following_id);
        $following->notify(new NewFollowerNotification($follower));

        if ($request->expectsJson()) {
            return [
                'unfollow' => 1,
                'id' => $following_id,
            ];
        }
        return redirect()->back();
    }

    public function unfollow(Request $request)
    {
        $request->validate([
            'following_id' => 'required|exists:users,id',
        ]);

        $follower = Auth::user();
        $following_id = $request->post('following_id');
        
        $follower->followings()->detach($following_id);

        if ($request->expectsJson()) {
            return [
                'follow' => 1,
                'id' => $following_id,
            ];
        }
        return redirect()->back();
    }
}
