<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', [MainController::class, 'displayHomePage']);
Route::get('/services', [MainController::class, 'displayServices']);
Route::get('/plans', [MainController::class, 'viewPlans']);
Route::get('/branches', [MainController::class, 'viewAllBranches']);
Route::get('/contact', function () {
    return view('pages.contact');
});



// Route::get('/dashboard', function () {
//     //return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    

    Route::get('/rent-storage', [MainController::class, 'displayCities']);
    Route::get('/rent-storage/{cityId}', [MainController::class, 'displayBranches']);
    Route::get('/rent-storage/{cityId}/{branchId}', [MainController::class, 'displayUnits']);
    Route::post('/rent-storage/{cityId}/{branchId}/process', [MainController::class, 'proccessOrder']);

    Route::get('/rent-cold-storage', [MainController::class, 'displayCities']);
    Route::get('/rent-cold-storage/{cityId}', [MainController::class, 'displayBranches']);
    Route::get('/rent-cold-storage/{cityId}/{branchId}', [MainController::class, 'displayRefrigeratedUnits']);
    Route::post('/rent-cold-storage/{cityId}/{branchId}/process', [MainController::class, 'proccessRefrigeratedOrder']);


    Route::get('/myProfile', [MainController::class, 'viewUserProfile']);
    Route::get('/orderDetails/{orderId}', [MainController::class, 'viewOrderDetails']);



    Route::get('/dashboard', [MainController::class, 'viewAdminDashboard'])->name('dashboard');
    Route::get('/reviewOrder/{orderId}', [MainController::class, 'reviewOrder']);

    Route::get('/orderConfirm/{orderId}', [MainController::class, 'orderConfirm']);
    Route::get('/orderCancel/{orderId}', [MainController::class, 'orderCancel']);

    Route::get('/plans/{planId}', [MainController::class, 'PurchasePlan']);
    Route::post('/plans/{planId}/process', [MainController::class, 'ActuallyPurchasePlan']);


});

require __DIR__.'/auth.php';
