<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OutgoingController;
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

Route::get('/logout', [AuthController::class, 'logout'])->middleware('login');
// admin
Route::get('/newUser', [UserController::class, 'new_user_page'])->middleware('security');
Route::get('/manageUser', [UserController::class, 'manage_user_page'])->middleware('security');
Route::post('/makeUser', [Usercontroller::class, 'makeUser'])->middleware('security');
Route::get('/deleteUser/{id}', [UserController::class, 'destroy'])->middleware('security');
Route::post('/tex',            [UserController::class, 'tex'])->middleware('security');

// buat tombol navbar samping

//customer
Route::get('/manageCustomer', [CustomerController::class, 'manage_customer_page'])->middleware('login');
Route::get('/newCustomer', [CustomerController::class, 'new_customer_page'])->middleware('login');
Route::post('/makeCustomer', [CustomerController::class, 'makeCustomer'])->middleware('login');
Route::get('/deleteCustomer/{id}', [CustomerController::class, 'deleteCustomer'])->middleware('login');
Route::post('/updateCustomer', [CustomerController::class, 'updateCustomer'])->middleware('login');

//brand
Route::get('/newBrand', [BrandController::class, 'new_brand_page'])->middleware('login');
Route::get('/manageBrand', [BrandController::class, 'manage_brand_page'])->middleware('login');
Route::post('/makeBrand', [BrandController::class, 'makeBrand'])->middleware('login');
Route::get('/deleteBrand/{id}', [BrandController::class, 'deleteBrand'])->middleware('login');
Route::post('/updateBrand', [BrandController::class, 'updateBrand'])->middleware('login');

//item
Route::get('/newItem', [ItemController::class, 'new_item_page']);
Route::post('/makeItem', [ItemController::class, 'makeItem']);
Route::get('/manageItem', [ItemController::class, 'manage_item_page']);
Route::get('/deleteItem/{id}', [ItemController::class, 'deleteItem']);
Route::post('/updateItem', [ItemController::class, 'updateItem']);
Route::get('/manageHistory', [ItemController::class, 'item_history_page']);

//incoming
Route::post('/addItemStock', [IncomingController::class, 'addItemStock']);
Route::get('/newIncoming', [IncomingController::class, 'add_incoming_item_page']);
Route::post('/exportIncoming', [IncomingController::class, 'exportIncoming'])->name('exportIncoming');
Route::post('/exportIncomingCustomer', [IncomingController::class, 'exportIncomingCustomer'])->name('exportIncomingCustomer');
Route::post('/exportIncomingBrand', [IncomingController::class, 'exportIncomingBrand'])->name('exportIncomingBrand');
Route::post('/exportIncomingItem', [IncomingController::class, 'exportIncomingItem'])->name('exportIncomingItem');

//outgoing
Route::post('/reduceItemStock', [OutgoingController::class, 'reduceItemStock']);
Route::get('/newOutgoing', [OutgoingController::class, 'add_outgoing_item_page']);


// export
Route::post('/exportExcel', [UserController::class, 'exportExcel'])->name('exportExcel'); //export user
