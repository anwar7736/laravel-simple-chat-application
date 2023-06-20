<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Auth::routes();

Route::middleware('guest')->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    });
});

Route::middleware('auth')->group(function(){
    Route::resource('message', MessageController::class);
});





Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
