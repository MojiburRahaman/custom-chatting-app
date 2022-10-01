<?php

use App\Events\TestEvent;
use App\Http\Controllers\Frontend\Chat\ChatController;
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

Route::get('/', function () {
    return view('welcome');

Route::middleware('activity','auth')->group(function(){
    
    // Route::post('/fetch-user', [ChatController::class, 'FetchUserList'])->name('FetchUserList');
    Route::post('/send-message', [ChatController::class, 'SendMessage'])->name('SendMessage');
    Route::post('/search', [ChatController::class, 'ChatSearchUser'])->name('ChatSearchUser');
    Route::post('/search/user', [ChatController::class, 'FetchUser'])->name('FetchUser');
    Route::get('/message', [ChatController::class, 'Chatview'])->name('Chatview');
    
    Route::get('/dashboard', function () {
        return redirect()->route('Chatview');
    
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

});


require __DIR__ . '/auth.php';
