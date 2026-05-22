<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});



// Post Management Routes
Route::resource('posts', PostController::class);
Route::patch('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
Route::delete('posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete');