<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OutgoingController;
use App\Http\Controllers\PalletController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\UserController;
use App\Models\StockHistory;
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

Route::get('/creds/{id}', [AuthController::class, 'show_creds'])->middleware('login');
Route::post('/updateUser', [AuthController::class, 'updateUser'])->middleware('login');

Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('all');
// Route::get('home', [HomeController::class, 'index'])->middleware('security');

Route::post('/login', [AuthController::class, 'cek_login']);

Route::get('/logout', [AuthController::class, 'logout'])->middleware('all');
// admin
Route::get('/newUser', [UserController::class, 'new_user_page'])->middleware('security');
Route::get('/manageUser', [UserController::class, 'manage_user_page'])->middleware('security');
Route::post('/makeUser', [Usercontroller::class, 'makeUser'])->middleware('security');
Route::get('/deleteUser/{id}', [UserController::class, 'destroy'])->middleware('security');
Route::post('/tex',            [UserController::class, 'tex'])->middleware('security');
Route::post('/newPasswordFromAdmin', [UserController::class, 'newPasswordFromAdmin'])->middleware('security');
Route::get('/userAccess/{id}', [UserController::class, 'user_access_page'])->middleware('security');
Route::post('/addNewUserAccess', [UserController::class, 'add_new_user_access'])->middleware('security');
Route::get('/deleteAccess/{id}', [UserController::class, 'delete_user_access'])->middleware('security');
Route::post('/customerAssign', [UserController::class, 'customer_assign'])->middleware('security');

// buat tombol navbar samping

//customer
Route::get('/manageCustomer', [CustomerController::class, 'manage_customer_page'])->middleware('security');
Route::get('/newCustomer', [CustomerController::class, 'new_customer_page'])->middleware('security');
Route::post('/makeCustomer', [CustomerController::class, 'makeCustomer'])->middleware('security');
Route::get('/deleteCustomer/{id}', [CustomerController::class, 'deleteCustomer'])->middleware('security');
Route::post('/updateCustomer', [CustomerController::class, 'updateCustomer'])->middleware('security');
Route::get('/exportCustomerExcel', [CustomerController::class, 'exportCustomerExcel'])->name('exportCustomerExcel')->middleware('security');

//brand
Route::get('/newBrand', [BrandController::class, 'new_brand_page'])->middleware('security');
Route::get('/manageBrand', [BrandController::class, 'manage_brand_page'])->middleware('security');
Route::post('/makeBrand', [BrandController::class, 'makeBrand'])->middleware('security');
Route::get('/deleteBrand/{id}', [BrandController::class, 'deleteBrand'])->middleware('security');
Route::post('/updateBrand', [BrandController::class, 'updateBrand'])->middleware('security');
Route::post('exportCustomerBrand', [BrandController::class, 'exportCustomerBrand'])->name('exportCustomerBrand')->middleware('security');

//item & stockhistory
Route::get('/newItem', [ItemController::class, 'new_item_page'])->middleware('security');
Route::post('/makeItem', [ItemController::class, 'makeItem'])->middleware('security');
Route::get('/manageItem', [ItemController::class, 'manage_item_page'])->middleware('security');
Route::get('/deleteItem/{id}', [ItemController::class, 'deleteItem'])->middleware('security');
Route::post('/updateItem', [ItemController::class, 'updateItem'])->middleware('security');
Route::get('/manageHistory', [ItemController::class, 'item_history_page'])->middleware('all');
Route::post('/exportCustomerItem', [ItemController::class, 'exportCustomerItem'])->name('exportCustomerItem')->middleware('security');
Route::post('/exportBrandItem', [ItemController::class, 'exportBrandItem'])->name('exportBrandItem')->middleware('security');
Route::post('/filterHistoryDate', [StockHistoryController::class, 'filterHistoryDate'])->middleware('all');
Route::post('/exportItemHistory', [StockHistoryController::class, 'exportItemHistory'])->name('exportItemHistory')->middleware('all');
Route::post('/exportHistoryByDate', [StockHistoryController::class, 'exportHistoryByDate'])->name('exportHistoryByDate')->middleware('all');

Route::get('/customerReport', [ItemController::class, 'customer_report_page'])->middleware('multirole');

//incoming
Route::post('/addItemStock', [IncomingController::class, 'addItemStock'])->middleware('login');
Route::get('/newIncoming', [IncomingController::class, 'add_incoming_item_page'])->middleware('login');
Route::get('/deleteItemIncoming/{id}', [IncomingController::class, 'deleteItemIncoming'])->middleware('login');
Route::post('/updateIncomingData', [IncomingController::class, 'updateIncomingData'])->middleware('login');
Route::post('/exportIncoming', [IncomingController::class, 'exportIncoming'])->name('exportIncoming')->middleware('login');
Route::post('/exportIncomingCustomer', [IncomingController::class, 'exportIncomingCustomer'])->name('exportIncomingCustomer')->middleware('login');
Route::post('/exportIncomingBrand', [IncomingController::class, 'exportIncomingBrand'])->name('exportIncomingBrand')->middleware('login');
Route::post('/exportIncomingItem', [IncomingController::class, 'exportIncomingItem'])->name('exportIncomingItem')->middleware('login');

//outgoing
Route::post('/reduceItemStock', [OutgoingController::class, 'reduceItemStock'])->middleware('login'); //cek
Route::get('/newOutgoing', [OutgoingController::class, 'add_outgoing_item_page'])->middleware('login');
Route::get('/deleteItemOutgoing/{id}', [OutgoingController::class, 'deleteItemOutgoing'])->middleware('login');
Route::post('/updateOutgoingData', [OutgoingController::class, 'updateOutgoingData'])->middleware('login');
Route::post('/exportOutgoing', [OutgoingController::class, 'exportOutgoing'])->name('exportOutgoing')->middleware('login');
Route::post('/exportOutgoingCustomer', [OutgoingController::class, 'exportOutgoingCustomer'])->name('exportOutgoingCustomer')->middleware('login');
Route::post('/exportOutgoingBrand', [OutgoingController::class, 'exportOutgoingBrand'])->name('exportOutgoingBrand')->middleware('login');
Route::post('/exportOutgoingItem', [OutgoingController::class, 'exportOutgoingItem'])->name('exportOutgoingItem')->middleware('login');

// Pallet
Route::get('/managePallet', [PalletController::class, 'manage_pallet_page'])->middleware('login');
Route::get('/managePalletHistory', [PalletController::class, 'manage_pallet_history_page'])->middleware('all');
Route::post('/addNewPallet', [PalletController::class, 'add_pallet'])->middleware('login');
Route::get('/removePallet/{id}', [PalletController::class, 'remove_pallet'])->middleware('login');
Route::post('/reducePalletStock', [PalletController::class, 'reduce_pallet_stock'])->middleware('login');
Route::post('/exportPalletItemHistory', [PalletController::class, 'exportPalletItemHistory'])->name('exportPalletItemHistory')->middleware('all');

// export
Route::get('/exportExcel', [UserController::class, 'exportExcel'])->name('exportExcel')->middleware('login'); //export user ALL
// Route::post('/exportExcel', [UserController::class, 'exportExcel'])->name('exportExcel'); //export user kalo ada atribut
