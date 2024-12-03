<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Transaction;
use App\Http\Controllers\MainController;

use Illuminate\Support\Facades\Route;

Route::get('/', [mainController::class, 'displayHomePage']);


Route::get('/dashboard', function () {
    //return view('dashboard');
    return redirect('/home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

});

require __DIR__.'/auth.php';
