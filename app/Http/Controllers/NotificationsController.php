<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        return view('notifications', [
            'notifications' => Auth::user()->notifications()->paginate(10),
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        if ($notification->data['action']) {
            return redirect()->to($notification->data['action']);
        }

        return redirect()->route('notifications'); 
    }

    public function update($id = null)
    {
        $user = Auth::user();
        $user->unreadNotifications()->when($id, function($query, $id) {
            $query->where('id', $id);
        })->markAsRead();

        return redirect()->route('notifications');
    }

    public function destroy($id = null)
    {
        $user = Auth::user();
        /*if ($id) {
            $user->notifications()->findOrFail($id)->delete();
        } else {
            $user->notifications()->delete();
        }*/

        $user->notifications()->when($id, function($query, $id) {
            $query->where('id', $id);
        })->delete();

        return redirect()->route('notifications');
        
    }
}
