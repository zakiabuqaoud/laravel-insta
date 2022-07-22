<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::get('posts', [PostsController::class, 'index']);
Route::get('posts/{id}', [PostsController::class, 'show']);
Route::post('posts', [PostsController::class, 'store']);
Route::put('posts/{id}', [PostsController::class, 'update']);
Route::delete('posts/{id}', [PostsController::class, 'destroy']);

Route::resource('posts', PostsController::class)->except('create', 'edit');*/

Route::apiResource('posts', PostsController::class)->middleware('auth:sanctum');

Route::post('login', [LoginController::class, 'login'])->middleware('guest:sanctum');
Route::delete('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::get('user', [LoginController::class, 'user'])->middleware('auth:sanctum');
