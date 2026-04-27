<?php

use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\SellerController;
use App\Mail\SellerApprovalMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//    return view('welcome');
//});

Route::get("/", [PageController::class, "home"])->name('home');

Route::post("/seller/request", [SellerController::class, "seller_request"])->name('seller.request');

Route::get("/product/{id}", [PageController::class, "product"])->name('product');

Route::get("/products", [PageController::class, "products"])->name('products');

//Route::get('/test-mail', function () {
//    Mail::to("bishalkajigurung@gmail.com")->send(new SellerApprovalMail());
//    return "email sent successfully";
// });


