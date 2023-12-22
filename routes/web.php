<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\InPalletController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OutgoingController;
use App\Http\Controllers\OutPalletController;
use App\Http\Controllers\PalletController;
use App\Http\Controllers\PalletHistoryController;
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
// Route::get('/', function () {
//     return view('login');
// });

Route::get('/loginPage', function () {
    return view('login');
});


Route::get('/', function () {
    return view('home');
})->middleware('role:auth');


// buat login bisa semuanya
Route::get('/', [HomeController::class, 'index'])->middleware('role:auth');
Route::post('/login', [AuthController::class, 'cek_login']);

// Route::get('/home', [HomeController::class, 'index'])->middleware('role:auth');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('role:auth');

// User Credentials
Route::get('/creds/{id}', [AuthController::class, 'show_creds'])->middleware('role:auth');
Route::post('/updateUser', [AuthController::class, 'updateUser'])->middleware('role:auth');

// HANYA BISA DIAKSES OLEH ADMIN
Route::middleware(['role:admin_page'])->group(function () {
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
    Route::get('/userPagePermission/{id}', [UserController::class, 'user_page_permission']);
    Route::post('/permissionToTrue', [UserController::class, 'permission_true']);
    Route::post('/permissionToFalse', [UserController::class, 'permission_false']);

    // Page: User Access
    Route::post('/addNewUserAccess', [UserController::class, 'add_new_user_access']);
    Route::get('/deleteAccess/{id}', [UserController::class, 'delete_user_access']);

});


// Page: Tambah Customer Baru
Route::get('/newCustomer', [CustomerController::class, 'new_customer_page'])->middleware('role:tambah_customer_baru');
Route::post('/makeCustomer', [CustomerController::class, 'makeCustomer'])->middleware('role:tambah_customer_baru');

// Page: Ubah Data Customer
Route::get('/manageCustomer', [CustomerController::class, 'manage_customer_page'])->middleware('role:data_customer');
Route::get('/deleteCustomer/{id}', [CustomerController::class, 'deleteCustomer'])->middleware('role:data_customer');
Route::post('/updateCustomer', [CustomerController::class, 'updateCustomer'])->middleware('role:data_customer');
Route::get('/exportCustomerExcel', [CustomerController::class, 'exportCustomerExcel'])->name('exportCustomerExcel')->middleware('role:data_customer');

// Page: Tambah Brand Baru
Route::get('/newBrand', [BrandController::class, 'new_brand_page'])->middleware('role:tambah_brand_baru');
Route::post('/makeBrand', [BrandController::class, 'makeBrand'])->middleware('role:tambah_brand_baru');

// Page: Ubah Data Brand
Route::get('/manageBrand', [BrandController::class, 'manage_brand_page'])->middleware('role:data_brand');
Route::get('/deleteBrand/{id}', [BrandController::class, 'deleteBrand'])->middleware('role:data_brand');
Route::post('/updateBrand', [BrandController::class, 'updateBrand'])->middleware('role:data_brand');
Route::post('exportCustomerBrand', [BrandController::class, 'exportCustomerBrand'])->name('exportCustomerBrand')->middleware('role:data_brand');

// Page: Tambah Barang Baru
Route::get('/newItem', [ItemController::class, 'new_item_page'])->middleware('role:tambah_barang_baru');
Route::post('/makeItem', [ItemController::class, 'makeItem'])->middleware('role:tambah_barang_baru');

// Page: Ubah Data Barang
Route::get('/manageItem', [ItemController::class, 'manage_item_page'])->middleware('role:data_barang');
Route::get('/deleteItem/{id}', [ItemController::class, 'deleteItem'])->middleware('role:data_barang');
Route::post('/updateItem', [ItemController::class, 'updateItem'])->middleware('role:data_barang');
Route::post('/exportCustomerItem', [ItemController::class, 'exportCustomerItem'])->name('exportCustomerItem')->middleware('role:data_barang');
Route::post('/exportBrandItem', [ItemController::class, 'exportBrandItem'])->name('exportBrandItem')->middleware('role:data_barang');

// Page: Barang Datang
Route::post('/addItemStock', [IncomingController::class, 'addItemStock'])->middleware('role:barang_datang');
Route::get('/newIncoming', [IncomingController::class, 'add_incoming_item_page'])->middleware('role:barang_datang');
Route::get('/deleteItemIncoming/{id}', [IncomingController::class, 'deleteItemIncoming'])->middleware('role:barang_datang');
Route::post('/updateIncomingData', [IncomingController::class, 'updateIncomingData'])->middleware('role:barang_datang');
Route::post('/exportIncoming', [IncomingController::class, 'exportIncoming'])->name('exportIncoming')->middleware('role:barang_datang');
Route::post('/exportIncomingCustomer', [IncomingController::class, 'exportIncomingCustomer'])->name('exportIncomingCustomer')->middleware('role:barang_datang');
Route::post('/exportIncomingBrand', [IncomingController::class, 'exportIncomingBrand'])->name('exportIncomingBrand')->middleware('role:barang_datang');
Route::post('/exportIncomingItem', [IncomingController::class, 'exportIncomingItem'])->name('exportIncomingItem')->middleware('role:barang_datang');

// Page: Barang Keluar
Route::post('/reduceItemStock', [OutgoingController::class, 'reduceItemStock'])->middleware('role:barang_keluar');
Route::get('/newOutgoing', [OutgoingController::class, 'add_outgoing_item_page'])->middleware('role:barang_keluar');
Route::get('/deleteItemOutgoing/{id}', [OutgoingController::class, 'deleteItemOutgoing'])->middleware('role:barang_keluar');
Route::post('/updateOutgoingData', [OutgoingController::class, 'updateOutgoingData'])->middleware('role:barang_keluar');
Route::post('/exportOutgoing', [OutgoingController::class, 'exportOutgoing'])->name('exportOutgoing')->middleware('role:barang_keluar');
Route::post('/exportOutgoingCustomer', [OutgoingController::class, 'exportOutgoingCustomer'])->name('exportOutgoingCustomer')->middleware('role:barang_keluar');
Route::post('/exportOutgoingBrand', [OutgoingController::class, 'exportOutgoingBrand'])->name('exportOutgoingBrand')->middleware('role:barang_keluar');
Route::post('/exportOutgoingItem', [OutgoingController::class, 'exportOutgoingItem'])->name('exportOutgoingItem')->middleware('role:barang_keluar');

// Pallet
// Route::get('/managePallet', [PalletController::class, 'manage_pallet_page'])->middleware('role:admin,gudang,cargo');

// inPallet
Route::get('/inPallet', [InPalletController::class, 'in_pallet_page'])->middleware('role:palet_masuk');
Route::post('/addNewPallet', [InPalletController::class, 'add_pallet'])->middleware('role:palet_masuk');
Route::post('/reducePalletStock', [InPalletController::class, 'reduce_pallet_stock'])->middleware('role:palet_masuk');

// outPallet
Route::get('/outPallet', [OutPalletController::class, 'out_pallet_page'])->middleware('role:palet_keluar');

// Page: History Stok by pcs
Route::get('/manageHistory', [ItemController::class, 'item_history_page'])->middleware('role:history_stok_by_pcs');
Route::post('/filterHistoryDate', [StockHistoryController::class, 'filterHistoryDate'])->middleware('role:history_stok_by_pcs');;
Route::post('/exportItemHistory', [StockHistoryController::class, 'exportItemHistory'])->name('exportItemHistory')->middleware('role:history_stok_by_pcs');;
Route::post('/exportHistoryByDate', [StockHistoryController::class, 'exportHistoryByDate'])->name('exportHistoryByDate')->middleware('role:history_stok_by_pcs');;

// Page: Laporan Stok by pcs
Route::get('/itemReport', [ItemController::class, 'item_report_page'])->middleware('role:laporan_stok_by_pcs');
Route::post('/exportItemReportCustomer', [ItemController::class, 'exportItemReportCustomer'])->middleware('role:laporan_stok_by_pcs');
Route::post('/exportItemReportBrand', [ItemController::class, 'exportItemReportBrand'])->middleware('role:laporan_stok_by_pcs');
Route::post('/exportItemReportItem', [ItemController::class, 'exportItemReportItem'])->middleware('role:laporan_stok_by_pcs');
Route::post('/exportItemReportDate', [ItemController::class, 'exportItemReportDate'])->middleware('role:laporan_stok_by_pcs');

// Page: Laporan Stok by palet
Route::get('/palletReport', [PalletController::class, 'pallet_report_page'])->middleware('role:laporan_stok_by_palet');
Route::post('/exportPalletReportCustomer', [PalletController::class, 'exportPalletReportCustomer'])->middleware('role:laporan_stok_by_palet');
Route::post('/exportPalletReportBrand', [PalletController::class, 'exportPalletReportBrand'])->middleware('role:laporan_stok_by_palet');
Route::post('/exportPalletReportItem', [PalletController::class, 'exportPalletReportItem'])->middleware('role:laporan_stok_by_palet');
Route::post('/exportPalletReportDate', [PalletController::class, 'exportPalletReportDate'])->middleware('role:laporan_stok_by_palet');

// Page: History Stok by palet
Route::get('/managePalletHistory', [PalletHistoryController::class, 'manage_pallet_history_page'])->middleware('role:history_stok_by_palet');
Route::post('/exportPalletItemHistory', [PalletHistoryController::class, 'exportPalletItemHistory'])->name('exportPalletItemHistory')->middleware('role:history_stok_by_palet');
Route::post('/exportPalletHistoryByDate', [PalletHistoryController::class, 'exportPalletHistoryByDate'])->name('exportPalletHistoryByDate')->middleware('role:history_stok_by_palet');
Route::post('/filterPalletHistoryDate', [PalletHistoryController::class, 'filterPalletHistoryDate'])->middleware('role:history_stok_by_palet');

