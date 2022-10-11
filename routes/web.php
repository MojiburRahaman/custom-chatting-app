<?php

use App\Events\TestEvent;
use App\Http\Controllers\Frontend\Chat\ChatController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
    return view('New.new');
    return view('New.master');
});
Route::middleware('activity', 'auth')->group(function () {

    Route::post('/pusher/auth', [ChatController::class, 'PusherAuth'])->name('PusherAuth');
    Route::post('/typing', [ChatController::class, 'Typing'])->name('Typing');
    Route::post('/send-message', [ChatController::class, 'SendMessage'])->name('SendMessage');
    Route::post('/search', [ChatController::class, 'ChatSearchUser'])->name('ChatSearchUser');
    // Route::post('/search/user', [ChatController::class, 'FetchUser'])->name('FetchUser');
    Route::get('/message', [ChatController::class, 'Chatview'])->name('Chatview');
    Route::get('/message/{slug}', [ChatController::class, 'FetchUser'])->name('ChatFetchUserview');

    Route::get('/dashboard', function () {
        return redirect()->route('Chatview');
    })->middleware(['auth',])->name('dashboard');
});


require __DIR__ . '/auth.php';
