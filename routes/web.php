<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/articles/trash', [ArticleController::class, 'trash'])->name('articles.trash');
    Route::post('/articles/{id}/restore', [ArticleController::class, 'restore'])->name('articles.restore');
    Route::delete('/articles/{id}/force', [ArticleController::class, 'forceDelete'])->name('articles.forceDelete');
    Route::resource('articles', ArticleController::class);
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
