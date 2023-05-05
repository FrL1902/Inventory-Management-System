<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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
    return view('login');
});


Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('login');
// Route::get('home', [HomeController::class, 'index'])->middleware('security');

Route::post('/login', [AuthController::class, 'cek_login']);

Route::get('/logout', [AuthController::class, 'logout']);

// admin
Route::get('/newUser', [UserController::class, 'new_user_page'])->middleware('security');
Route::get('/manageUser', [UserController::class, 'manage_user_page'])->middleware('security');
Route::post('/makeUser', [Usercontroller::class, 'makeUser']);
Route::get('/deleteUser/{id}', [UserController::class, 'destroy']);
Route::post('/tex',            [UserController::class, 'update']);

// buat tombol navbar samping

//customer
Route::get('/manageCustomer', [CustomerController::class, 'manage_customer_page'])->middleware('login');
Route::get('/newCustomer', [CustomerController::class, 'new_customer_page'])->middleware('login');
Route::post('/makeCustomer', [CustomerController::class, 'makeCustomer'])->middleware('login');

//brand
Route::get('/newBrand', [BrandController::class, 'new_brand_page'])->middleware('login');
Route::get('/manageBrand', [BrandController::class, 'manage_brand_page'])->middleware('login');
Route::post('/makeBrand', [BrandController::class, 'makeBrand'])->middleware('login');
