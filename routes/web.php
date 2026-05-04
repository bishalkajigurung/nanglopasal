<?php

use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\SellerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get("/", [PageController::class, "home"])->name('home');

Route::post("/seller/request", [SellerController::class, "seller_request"])->name('seller.request');

Route::get("/product/{id}", [PageController::class, "product"])->name('product');

Route::get("/products", [PageController::class, "products"])->name('products');

Route::get("/login", [AuthController::class, "login"])->name('login');

//Route::get('/test-mail', function () {
//    Mail::to("bishalkajigurung@gmail.com")->send(new SellerApprovalMail());
//    return "email sent successfully";
// });

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
