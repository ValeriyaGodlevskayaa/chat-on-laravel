<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
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
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return Inertia::render('Dashboard', ['user' => $user]);
    })->name('dashboard');

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');

        Route::resource('/users', UserController::class);

        Route::prefix('chat')->group(function () {
            Route::resource('/', ChatController::class)->names('chat');
            Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
            Route::get('/clear/{chat}', [ChatController::class, 'clearChat'])->name('chat.clearChat');
        });
    });


});
