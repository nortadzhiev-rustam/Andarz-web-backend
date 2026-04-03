<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\InstructorController;
use Illuminate\Support\Facades\Route;

// ── Authentication ─────────────────────────────────────────────────────────────
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login',    [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('me',      [AuthController::class, 'me'])->name('me');
    });
});

// ── Courses (public read, auth write, admin full) ──────────────────────────────
Route::prefix('courses')->name('courses.')->group(function () {
    Route::get('/',                  [CourseController::class, 'index'])->name('index');
    Route::get('featured',           [CourseController::class, 'featured'])->name('featured');
    Route::get('by-slug/{slug}',     [CourseController::class, 'showBySlug'])->name('showBySlug');
    Route::get('{course}',           [CourseController::class, 'show'])->name('show')->whereNumber('course');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('{course}/enroll', [CourseController::class, 'enroll'])->name('enroll')->whereNumber('course');
    });

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::post('/',         [CourseController::class, 'store'])->name('store');
        Route::put('{course}',   [CourseController::class, 'update'])->name('update')->whereNumber('course');
        Route::delete('{course}',[CourseController::class, 'destroy'])->name('destroy')->whereNumber('course');
    });
});

// ── Blog (public read, admin write) ───────────────────────────────────────────
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/',                [BlogController::class, 'index'])->name('index');
    Route::get('by-slug/{slug}',   [BlogController::class, 'showBySlug'])->name('showBySlug');
    Route::get('{blog}',           [BlogController::class, 'show'])->name('show')->whereNumber('blog');

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::post('/',       [BlogController::class, 'store'])->name('store');
        Route::put('{blog}',   [BlogController::class, 'update'])->name('update')->whereNumber('blog');
        Route::delete('{blog}',[BlogController::class, 'destroy'])->name('destroy')->whereNumber('blog');
    });
});

// ── Instructors (public read, admin write) ─────────────────────────────────────
Route::prefix('instructors')->name('instructors.')->group(function () {
    Route::get('/',                    [InstructorController::class, 'index'])->name('index');
    Route::get('{instructor}',         [InstructorController::class, 'show'])->name('show')->whereNumber('instructor');

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::post('/',              [InstructorController::class, 'store'])->name('store');
        Route::put('{instructor}',    [InstructorController::class, 'update'])->name('update')->whereNumber('instructor');
        Route::delete('{instructor}', [InstructorController::class, 'destroy'])->name('destroy')->whereNumber('instructor');
    });
});
