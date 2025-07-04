<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\HomeSection;

Route::get('/', function () {
    $hero = Post::where('is_hero', true)->first();
    $posts = Post::latest();
    if ($hero) {
        $posts = $posts->where('id', '!=', $hero->id);
    }
    $posts = $posts->take(3)->get();
    $homeSections = HomeSection::all()->keyBy('section_key');
    return view('welcome', compact('posts', 'hero', 'homeSections'));
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dynamic Posts
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes (login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });
    
    // Protected admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        // Admin post management
        Route::get('/posts', [PostController::class, 'index'])->name('posts');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        Route::post('/posts/{post}/set-hero', [PostController::class, 'setHero'])->name('posts.setHero');
        
        // Admin user management
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Admin Home Sections (content editing)
        Route::get('{section_key}/edit', [\App\Http\Controllers\Admin\HomeSectionController::class, 'edit'])->name('home_sections.edit');
        Route::put('{section_key}', [\App\Http\Controllers\Admin\HomeSectionController::class, 'update'])->name('home_sections.update');
    });
});

Route::get('/posts', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Post::query();
    if ($request->search) {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('subtitle', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }
    $posts = $query->orderByDesc('date')->paginate(9);
    return view('posts.all', compact('posts'));
})->name('posts.all');

// Download routes
Route::get('/download/report/{filename}', [DownloadController::class, 'downloadReport'])->name('download.report');
Route::get('/download/file/{path}', [DownloadController::class, 'downloadFile'])->name('download.file')->where('path', '.*');

require __DIR__.'/auth.php';
