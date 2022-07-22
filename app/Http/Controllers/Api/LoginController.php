<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', '=', $request->post('username'))
            ->orWhere('email', '=', $request->post('username'))
            ->first();

        if ($user && Hash::check($request->post('password'), $user->password)) {

            $token = $user->createToken($request->userAgent(), ['posts', 'followers']);

            return [
                'message' => 'Authenticated',
                'token' => $token->plainTextToken,
                'user' => $user,
            ];
        }

        return new JsonResponse([
            'message' => 'Invalid username/password',
        ], 401);
    }

    public function logout()
    {
        // guards
        $user = Auth::guard('sanctum')->user();
        // Logout from the current device
        $user->currentAccessToken()->delete();

        // Logout from all devices
        //$user->tokens()->delete();

        // Logout from all devices except the current
        //$user->tokens()->where('id', '<>', $user->currentAccessToken()->id)->delete();

        return [
            'message' => 'token deleted',
        ];
    }

    public function user()
    {
        $user = Auth::guard('sanctum')->user();
        return $user->currentAccessToken();
    }
}
