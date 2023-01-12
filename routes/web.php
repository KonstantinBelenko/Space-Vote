<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PollController;

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

// Route get / to livewire home component
Route::get('/', HomeController::class)->name('home');

// Poll manipulation routes, only accessible to authenticated users
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/polls/create', [PollController::class, 'create'])->name('polls.create');
    Route::post('/polls', [PollController::class, 'store'])->name('polls.store');
    // Delete Poll
    Route::delete('/polls/{poll}', [PollController::class, 'destroy'])->name('polls.destroy');
});

// This route is public and accessible to everyone
Route::get('/polls/{poll}', [PollController::class, 'show'])->name('polls.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
