<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckAge;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PostsController::class, 'index'])->middleware([
    'auth',
])->name('home');

/*Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/create', [PostsController::class, 'create']);
Route::post('/posts', [PostsController::class, 'store']);
Route::get('/posts/{id}', [PostsController::class, 'show']);
Route::get('/posts/{id}/edit', [PostsController::class, 'edit']);
Route::put('/posts/{id}', [PostsController::class, 'update']);
Route::delete('/posts/{id}', [PostsController::class, 'destroy']);*/

Route::middleware(['auth'])
//->prefix('app')
//->as('app.')
//->namespace('\App\Http\Controllers')
->group(function() {

    Route::get('/posts/trash', [PostsController::class, 'trash'])->name('posts.trash');
    Route::put('/posts/trash/{id}', [PostsController::class, 'restore'])->name('posts.restore');
    Route::delete('/posts/trash/{id}', [PostsController::class, 'forceDelete'])->name('posts.force-delete');

    Route::resource('/posts', PostsController::class)->names([
        //'index' => 'posts.list',
    ]);

    Route::post('comments', [CommentsController::class, 'store'])->name('comments.store');

    Route::post('follow', [ProfileController::class, 'follow'])->name('follow');
    Route::post('unfollow', [ProfileController::class, 'unfollow'])->name('unfollow');
    
    Route::post('likes', [LikesController::class, 'store'])->name('likes.store');

    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/u/{username?}', [ProfileController::class, 'index'])->name('profile.index');

    Route::get('notifications', [NotificationsController::class, 'index'])->name('notifications');
    Route::get('notifications/{id}', [NotificationsController::class, 'show'])->name('notifications.show');
    Route::delete('notifications/{id?}', [NotificationsController::class, 'destroy'])->name('notifications.destroy');
    
    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('paypal/return', [CheckoutController::class, 'paypalReturn'])->name('paypal.return');
    Route::get('paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('paypal.cancel');
    
    
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
