<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('homepage');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/blog/{search?}', [PostController::class, 'index'])->name('blog');

Route::middleware(['auth'])->group(function () {
    Route::get('/getMyPosts', [PostController::class, 'getMyPosts'])->name('myPosts');
    Route::get('/deletePost/{id}', [PostController::class, 'deletePost'])->name('deletePost');
    Route::get('/hidePost/{id}', [PostController::class, 'hidePost'])->name('hidePost');
    Route::get('/hideComment/{id}', [CommentController::class, 'hideComment'])->name('hideComment');
    Route::get('/postComments/{id}', [CommentController::class, 'postComments'])->name('postComments');
    Route::post('/comment', [CommentController::class, 'comment'])->name('comment');
    Route::post('/postComment', [PostController::class, 'postComment'])->name('postComment');
    Route::get('/postComment/{id?}', function($id) {
        $post = null;
        if ($id) $post = Post::find($id);
        return inertia('Post', ['user' => auth()->user(), 'post' => $post]);
    })->name('getPostPage');
    Route::get('/viewPost/{id}', [PostController::class, 'viewPost'])->name('viewPost');
});
