<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\QuoteController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login',    [AuthController::class, 'login'])->name('login');
});

Route::prefix('quotes')->name('quotes.')->group(function () {
    Route::get('/',        [QuoteController::class, 'index'])->name('index');
    Route::get('featured', [QuoteController::class, 'featured'])->name('featured');
    Route::get('random',   [QuoteController::class, 'random'])->name('random');
    Route::get('{id}',     [QuoteController::class, 'show'])->name('show')->whereNumber('id');
});

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/',    [CategoryController::class, 'index'])->name('index');
    Route::get('{id}', [CategoryController::class, 'show'])->name('show')->whereNumber('id');
});

Route::prefix('authors')->name('authors.')->group(function () {
    Route::get('/',    [AuthorController::class, 'index'])->name('index');
    Route::get('{id}', [AuthorController::class, 'show'])->name('show')->whereNumber('id');
});

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('me',      [AuthController::class, 'me'])->name('me');
    });

    Route::prefix('quotes')->name('quotes.')->group(function () {
        Route::post('/',      [QuoteController::class, 'store'])->name('store');
        Route::put('{id}',    [QuoteController::class, 'update'])->name('update')->whereNumber('id');
        Route::delete('{id}', [QuoteController::class, 'destroy'])->name('destroy')->whereNumber('id');
    });

    // Admin-only write access
    Route::middleware('admin')->group(function () {
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::post('/',      [CategoryController::class, 'store'])->name('store');
            Route::put('{id}',    [CategoryController::class, 'update'])->name('update')->whereNumber('id');
            Route::delete('{id}', [CategoryController::class, 'destroy'])->name('destroy')->whereNumber('id');
        });
        Route::prefix('authors')->name('authors.')->group(function () {
            Route::post('/',      [AuthorController::class, 'store'])->name('store');
            Route::put('{id}',    [AuthorController::class, 'update'])->name('update')->whereNumber('id');
            Route::delete('{id}', [AuthorController::class, 'destroy'])->name('destroy')->whereNumber('id');
        });
    });
});
