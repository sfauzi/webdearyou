<?php

use App\Http\Controllers\BrowseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubmitController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/submit', [SubmitController::class, 'submit'])->name('submit');
Route::get('/browse', [BrowseController::class, 'browse'])->name('browse');
Route::get('/detail/{id}', [BrowseController::class, 'detail'])->name('detail');
Route::post('/submit', [SubmitController::class, 'store'])->name('submit.store');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
