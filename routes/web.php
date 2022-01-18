<?php

use App\Http\Controllers\ChatsController;
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
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/chat', [ChatsController::class, 'chatIndex'])->name('chat');

Route::get('/test', function () {
    return Inertia::render('Test');
});

Route::get('/chat/messages/{roomId}', [ChatsController::class, 'fetchMessages'])->name('chat.messages');

Route::post('/chat/send', [ChatsController::class, 'sendMessage'])->name('chat.send');

Route::post('/chat/create/room', [ChatsController::class, 'createRoom'])->name('chat.create');

Route::delete('/chat/delete/message/{roomId}', [ChatsController::class, 'deleteMessage'])->name('chat.delete');
