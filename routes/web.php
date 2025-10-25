<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// For view 
Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');

// Actual form submissions (POST)
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Route::get('/ninjas', [], 'index')->name('ninja.index');
// Route::get('/ninjas/create', [], 'create')->name('ninja.create');
// Route::get('/ninjas/{ninja}', [], 'show')->name('ninja.show');
// Route::post('/ninjas', [], 'store')->name('ninja.store');
// Route::delete('/ninjas/{ninja}', [], 'destroy')->name('ninja.destroy');

