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

// LOGIN PAGE, DEFAULT ROUTE '/'
Route::get('/', function () {
    return view('login');
});

// buat login bisa semuanya
Route::post('/login', [AuthController::class, 'cek_login']);

// HANYA BISA DIAKSES OLEH ADMIN
Route::middleware(['role:admin'])->group(function () {
    // Page: Tambah User Baru
    Route::get('/newUser', [UserController::class, 'new_user_page']);
    Route::post('/makeUser', [Usercontroller::class, 'makeUser']);

    // Page: Ubah Data User
    Route::get('/manageUser', [UserController::class, 'manage_user_page']);
    Route::get('/deleteUser/{id}', [UserController::class, 'destroy']);
    Route::post('/tex',            [UserController::class, 'tex']);
    Route::post('/newPasswordFromAdmin', [UserController::class, 'newPasswordFromAdmin']);
    Route::post('/customerAssign', [UserController::class, 'customer_assign']);
    Route::get('/exportExcel', [UserController::class, 'exportExcel'])->name('exportExcel'); //export user ALL
    Route::get('/userAccess/{id}', [UserController::class, 'user_access_page']);

    // Page: User Access (LAGI NGGA DIPAKE)
    Route::post('/addNewUserAccess', [UserController::class, 'add_new_user_access']);
    Route::get('/deleteAccess/{id}', [UserController::class, 'delete_user_access']);

    // Page: Tambah Customer Baru
    Route::get('/newCustomer', [CustomerController::class, 'new_customer_page']);
    Route::post('/makeCustomer', [CustomerController::class, 'makeCustomer']);

    // Page: Ubah Data Customer
    Route::get('/manageCustomer', [CustomerController::class, 'manage_customer_page']);
    Route::get('/deleteCustomer/{id}', [CustomerController::class, 'deleteCustomer']);
    Route::post('/updateCustomer', [CustomerController::class, 'updateCustomer']);
    Route::get('/exportCustomerExcel', [CustomerController::class, 'exportCustomerExcel'])->name('exportCustomerExcel');

    // Page: Tambah Brand Baru
    Route::get('/newBrand', [BrandController::class, 'new_brand_page']);
    Route::post('/makeBrand', [BrandController::class, 'makeBrand']);

    // Page: Ubah Data Brand
    Route::get('/manageBrand', [BrandController::class, 'manage_brand_page']);
    Route::get('/deleteBrand/{id}', [BrandController::class, 'deleteBrand']);
    Route::post('/updateBrand', [BrandController::class, 'updateBrand']);
    Route::post('exportCustomerBrand', [BrandController::class, 'exportCustomerBrand'])->name('exportCustomerBrand');
});

//Combination of role middlewares starts here================

// Page: Laporan Stok by pcs
Route::get('/itemReport', [ItemController::class, 'item_report_page'])->middleware('role:admin,customer,cargo');
Route::post('/exportItemReport', [ItemController::class, 'exportItemReport'])->middleware('role:admin,customer,cargo');

// Page: Tambah Barang Baru
Route::get('/newItem', [ItemController::class, 'new_item_page'])->middleware('role:admin,cargo');
Route::post('/makeItem', [ItemController::class, 'makeItem'])->middleware('role:admin,cargo');

// Page: Ubah Data Barang
Route::get('/manageItem', [ItemController::class, 'manage_item_page'])->middleware('role:admin,cargo');
Route::get('/deleteItem/{id}', [ItemController::class, 'deleteItem'])->middleware('role:admin,cargo');
Route::post('/updateItem', [ItemController::class, 'updateItem'])->middleware('role:admin,cargo');
Route::post('/exportCustomerItem', [ItemController::class, 'exportCustomerItem'])->name('exportCustomerItem')->middleware('role:admin,cargo');
Route::post('/exportBrandItem', [ItemController::class, 'exportBrandItem'])->name('exportBrandItem')->middleware('role:admin,cargo');

// Page: Barang Datang
Route::post('/addItemStock', [IncomingController::class, 'addItemStock'])->middleware('role:admin,gudang,cargo');
Route::get('/newIncoming', [IncomingController::class, 'add_incoming_item_page'])->middleware('role:admin,gudang,cargo');
Route::get('/deleteItemIncoming/{id}', [IncomingController::class, 'deleteItemIncoming'])->middleware('role:admin,gudang,cargo');
Route::post('/updateIncomingData', [IncomingController::class, 'updateIncomingData'])->middleware('role:admin,gudang,cargo');
Route::post('/exportIncoming', [IncomingController::class, 'exportIncoming'])->name('exportIncoming')->middleware('role:admin,gudang,cargo');
Route::post('/exportIncomingCustomer', [IncomingController::class, 'exportIncomingCustomer'])->name('exportIncomingCustomer')->middleware('role:admin,gudang,cargo');
Route::post('/exportIncomingBrand', [IncomingController::class, 'exportIncomingBrand'])->name('exportIncomingBrand')->middleware('role:admin,gudang,cargo');
Route::post('/exportIncomingItem', [IncomingController::class, 'exportIncomingItem'])->name('exportIncomingItem')->middleware('role:admin,gudang,cargo');

// Page: Barang Keluar
Route::post('/reduceItemStock', [OutgoingController::class, 'reduceItemStock'])->middleware('role:admin,gudang,cargo');
Route::get('/newOutgoing', [OutgoingController::class, 'add_outgoing_item_page'])->middleware('role:admin,gudang,cargo');
Route::get('/deleteItemOutgoing/{id}', [OutgoingController::class, 'deleteItemOutgoing'])->middleware('role:admin,gudang,cargo');
Route::post('/updateOutgoingData', [OutgoingController::class, 'updateOutgoingData'])->middleware('role:admin,gudang,cargo');
Route::post('/exportOutgoing', [OutgoingController::class, 'exportOutgoing'])->name('exportOutgoing')->middleware('role:admin,gudang,cargo');
Route::post('/exportOutgoingCustomer', [OutgoingController::class, 'exportOutgoingCustomer'])->name('exportOutgoingCustomer')->middleware('role:admin,gudang,cargo');
Route::post('/exportOutgoingBrand', [OutgoingController::class, 'exportOutgoingBrand'])->name('exportOutgoingBrand')->middleware('role:admin,gudang,cargo');
Route::post('/exportOutgoingItem', [OutgoingController::class, 'exportOutgoingItem'])->name('exportOutgoingItem')->middleware('role:admin,gudang,cargo');

// Pallet
Route::get('/managePallet', [PalletController::class, 'manage_pallet_page'])->middleware('role:admin,gudang,cargo');
Route::post('/addNewPallet', [PalletController::class, 'add_pallet'])->middleware('role:admin,gudang,cargo');
Route::get('/removePallet/{id}', [PalletController::class, 'remove_pallet'])->middleware('role:admin,gudang,cargo');
Route::post('/reducePalletStock', [PalletController::class, 'reduce_pallet_stock'])->middleware('role:admin,gudang,cargo');

// Page: Laporan Stok by palet
Route::get('/palletReport', [PalletController::class, 'pallet_report_page'])->middleware('role:admin,customer,cargo');


//Combination of role middlewares ends here ================

// BISA DIAKSES SEMUA
Route::middleware(['role:admin,customer,gudang,cargo'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout']);

    // Page: Sejarah Semua Barang
    Route::get('/manageHistory', [ItemController::class, 'item_history_page']);
    Route::post('/filterHistoryDate', [StockHistoryController::class, 'filterHistoryDate']);
    Route::post('/exportItemHistory', [StockHistoryController::class, 'exportItemHistory'])->name('exportItemHistory');
    Route::post('/exportHistoryByDate', [StockHistoryController::class, 'exportHistoryByDate'])->name('exportHistoryByDate');

    // Page: Sejarah Palet
    Route::get('/managePalletHistory', [PalletController::class, 'manage_pallet_history_page']);
    Route::post('/exportPalletItemHistory', [PalletController::class, 'exportPalletItemHistory'])->name('exportPalletItemHistory');
    Route::post('/exportPalletHistoryByDate', [PalletController::class, 'exportPalletHistoryByDate'])->name('exportPalletHistoryByDate');
    Route::post('/filterPalletHistoryDate', [PalletController::class, 'filterPalletHistoryDate']);

    // User Credentials
    Route::get('/creds/{id}', [AuthController::class, 'show_creds']);
    Route::post('/updateUser', [AuthController::class, 'updateUser']);
});


// Route::post('/exportExcel', [UserController::class, 'exportExcel'])->name('exportExcel'); //export user kalo ada atribut


// OLD UNORGANIZED ================================================================================================================================
// Route::get('/', function () {
//     return view('login');
// });

// Route::get('/creds/{id}', [AuthController::class, 'show_creds'])->middleware('login');
// Route::post('/updateUser', [AuthController::class, 'updateUser'])->middleware('login');

// Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('all');
// // Route::get('home', [HomeController::class, 'index'])->middleware('security');

// Route::post('/login', [AuthController::class, 'cek_login']);

// Route::get('/logout', [AuthController::class, 'logout'])->middleware('all');
// // admin
// Route::get('/newUser', [UserController::class, 'new_user_page'])->middleware('security');
// Route::get('/manageUser', [UserController::class, 'manage_user_page'])->middleware('security');
// Route::post('/makeUser', [Usercontroller::class, 'makeUser'])->middleware('security');
// Route::get('/deleteUser/{id}', [UserController::class, 'destroy'])->middleware('security');
// Route::post('/tex',            [UserController::class, 'tex'])->middleware('security');
// Route::post('/newPasswordFromAdmin', [UserController::class, 'newPasswordFromAdmin'])->middleware('security');
// Route::get('/userAccess/{id}', [UserController::class, 'user_access_page'])->middleware('security');
// Route::post('/addNewUserAccess', [UserController::class, 'add_new_user_access'])->middleware('security');
// Route::get('/deleteAccess/{id}', [UserController::class, 'delete_user_access'])->middleware('security');
// Route::post('/customerAssign', [UserController::class, 'customer_assign'])->middleware('security');

// // buat tombol navbar samping

// //customer
// Route::get('/manageCustomer', [CustomerController::class, 'manage_customer_page'])->middleware('security');
// Route::get('/newCustomer', [CustomerController::class, 'new_customer_page'])->middleware('security');
// Route::post('/makeCustomer', [CustomerController::class, 'makeCustomer'])->middleware('security');
// Route::get('/deleteCustomer/{id}', [CustomerController::class, 'deleteCustomer'])->middleware('security');
// Route::post('/updateCustomer', [CustomerController::class, 'updateCustomer'])->middleware('security');
// Route::get('/exportCustomerExcel', [CustomerController::class, 'exportCustomerExcel'])->name('exportCustomerExcel')->middleware('security');

// //brand
// Route::get('/newBrand', [BrandController::class, 'new_brand_page'])->middleware('security');
// Route::get('/manageBrand', [BrandController::class, 'manage_brand_page'])->middleware('security');
// Route::post('/makeBrand', [BrandController::class, 'makeBrand'])->middleware('security');
// Route::get('/deleteBrand/{id}', [BrandController::class, 'deleteBrand'])->middleware('security');
// Route::post('/updateBrand', [BrandController::class, 'updateBrand'])->middleware('security');
// Route::post('exportCustomerBrand', [BrandController::class, 'exportCustomerBrand'])->name('exportCustomerBrand')->middleware('security');

// //item & stockhistory
// Route::get('/newItem', [ItemController::class, 'new_item_page'])->middleware('security');
// Route::post('/makeItem', [ItemController::class, 'makeItem'])->middleware('security');
// Route::get('/manageItem', [ItemController::class, 'manage_item_page'])->middleware('security');
// Route::get('/deleteItem/{id}', [ItemController::class, 'deleteItem'])->middleware('security');
// Route::post('/updateItem', [ItemController::class, 'updateItem'])->middleware('security');
// Route::get('/manageHistory', [ItemController::class, 'item_history_page'])->middleware('all');
// Route::post('/exportCustomerItem', [ItemController::class, 'exportCustomerItem'])->name('exportCustomerItem')->middleware('security');
// Route::post('/exportBrandItem', [ItemController::class, 'exportBrandItem'])->name('exportBrandItem')->middleware('security');
// Route::post('/filterHistoryDate', [StockHistoryController::class, 'filterHistoryDate'])->middleware('all');
// Route::post('/exportItemHistory', [StockHistoryController::class, 'exportItemHistory'])->name('exportItemHistory')->middleware('all');
// Route::post('/exportHistoryByDate', [StockHistoryController::class, 'exportHistoryByDate'])->name('exportHistoryByDate')->middleware('all');

// Route::get('/customerReport', [ItemController::class, 'customer_report_page'])->middleware('multirole');
// Route::post('/exportItemReport', [ItemController::class, 'exportItemReport'])->middleware('multirole');

// //incoming
// Route::post('/addItemStock', [IncomingController::class, 'addItemStock'])->middleware('login');
// Route::get('/newIncoming', [IncomingController::class, 'add_incoming_item_page'])->middleware('login');
// Route::get('/deleteItemIncoming/{id}', [IncomingController::class, 'deleteItemIncoming'])->middleware('login');
// Route::post('/updateIncomingData', [IncomingController::class, 'updateIncomingData'])->middleware('login');
// Route::post('/exportIncoming', [IncomingController::class, 'exportIncoming'])->name('exportIncoming')->middleware('login');
// Route::post('/exportIncomingCustomer', [IncomingController::class, 'exportIncomingCustomer'])->name('exportIncomingCustomer')->middleware('login');
// Route::post('/exportIncomingBrand', [IncomingController::class, 'exportIncomingBrand'])->name('exportIncomingBrand')->middleware('login');
// Route::post('/exportIncomingItem', [IncomingController::class, 'exportIncomingItem'])->name('exportIncomingItem')->middleware('login');

// //outgoing
// Route::post('/reduceItemStock', [OutgoingController::class, 'reduceItemStock'])->middleware('login'); //cek
// Route::get('/newOutgoing', [OutgoingController::class, 'add_outgoing_item_page'])->middleware('login');
// Route::get('/deleteItemOutgoing/{id}', [OutgoingController::class, 'deleteItemOutgoing'])->middleware('login');
// Route::post('/updateOutgoingData', [OutgoingController::class, 'updateOutgoingData'])->middleware('login');
// Route::post('/exportOutgoing', [OutgoingController::class, 'exportOutgoing'])->name('exportOutgoing')->middleware('login');
// Route::post('/exportOutgoingCustomer', [OutgoingController::class, 'exportOutgoingCustomer'])->name('exportOutgoingCustomer')->middleware('login');
// Route::post('/exportOutgoingBrand', [OutgoingController::class, 'exportOutgoingBrand'])->name('exportOutgoingBrand')->middleware('login');
// Route::post('/exportOutgoingItem', [OutgoingController::class, 'exportOutgoingItem'])->name('exportOutgoingItem')->middleware('login');

// // Pallet
// Route::get('/managePallet', [PalletController::class, 'manage_pallet_page'])->middleware('login');
// Route::get('/managePalletHistory', [PalletController::class, 'manage_pallet_history_page'])->middleware('all');
// Route::post('/addNewPallet', [PalletController::class, 'add_pallet'])->middleware('login');
// Route::get('/removePallet/{id}', [PalletController::class, 'remove_pallet'])->middleware('login');
// Route::post('/reducePalletStock', [PalletController::class, 'reduce_pallet_stock'])->middleware('login');
// Route::post('/exportPalletItemHistory', [PalletController::class, 'exportPalletItemHistory'])->name('exportPalletItemHistory')->middleware('all');
// Route::post('/exportPalletHistoryByDate', [PalletController::class, 'exportPalletHistoryByDate'])->name('exportPalletHistoryByDate')->middleware('all');
// Route::post('/filterPalletHistoryDate', [PalletController::class, 'filterPalletHistoryDate'])->middleware('all');

// // export
// Route::get('/exportExcel', [UserController::class, 'exportExcel'])->name('exportExcel')->middleware('login'); //export user ALL
// // Route::post('/exportExcel', [UserController::class, 'exportExcel'])->name('exportExcel'); //export user kalo ada atribut
