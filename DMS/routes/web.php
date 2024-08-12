<?php

use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');

Route::middleware('auth')->group(function(){
    Route::get('/', Dashboard::class)->name('dashboard');
});
