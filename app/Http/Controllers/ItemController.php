<?php

namespace App\Http\Controllers;

use App\Exports\CustomerReportExport;
use App\Exports\editItemExport;
use App\Exports\ItemReportExport;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Incoming;
use App\Models\Item;
use App\Models\Outgoing;
use App\Models\StockHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class ItemController extends Controller
{
    public function new_item_page()
    {
        $brand = Brand::all();
        return view('new_views.newItem', compact('brand'));
    }

    public function makeItem(Request $request)
    {

        $item = new Item();
        $customer = Brand::find($request->brandidforitem);

        $request->validate([
            'brandidforitem' => 'required',
            'itemid' => 'required',
            'itemname' => 'required',
            'itemImage' => 'required',
        ], [
            'brandidforitem.required' => 'Kolom "Brand Pemilik Barang" harus dipilih',
            'itemid.required' => 'Kolom "ID Barang" harus diisi',
            'itemname.required' => 'Kolom "Nama Barang" harus diisi',
            'itemImage.required' => 'Gambar harus ada di kolom "Foto Barang"',
        ]);

        $request->validate([
            'itemid' => 'required|unique:App\Models\Item,item_id|min:3|max:20|alpha_dash',
            'itemname' => 'required|unique:App\Models\Item,item_name|min:3|max:75|regex:/^[\pL\s\-\0-9]+$/u', //ga perlu pake unique sih, soalnya udah ada item_id, tp gpp buat skrg deh, //ini regex lama tanpa pake number /^[\pL\s\-]+$/u  , ini yg baru  /^[\pL\s\-\0-9]+$/u
            'itemImage' => 'required|mimes:jpeg,png,jpg|max:10240',
        ], [
            'itemid.required' => 'Kolom "ID Barang" harus diisi',
            'itemid.unique' => '"ID Barang" yang diisi sudah terambil, masukkan ID yang lain',
            'itemid.min' => '"ID Barang" minimal 3 karakter',
            'itemid.max' => '"ID Barang" maksimal 20 karakter',
            'itemid.alpha_dash' => '"ID Barang" hanya membolehkan huruf, angka, -, _ (spasi dan simbol lainnya tidak diterima)',
            'itemname.required' => 'Kolom "Nama Barang" harus diisi',
            'itemname.unique' => '"Nama Barang" yang diisi sudah terambil, masukkan nama yang lain',
            'itemname.min' => '"Nama Barang" minimal 3 karakter',
            'itemname.max' => '"Nama Barang" maksimal 75 karakter',
            'itemname.regex' => '"Nama Barang" hanya membolehkan huruf, angka, spasi, dan tanda penghubung(-)',
            'itemImage.required' => 'Gambar harus ada di kolom "Foto Barang"',
            'itemImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png',
            'itemImage.max' => 'Ukuran foto harus dibawah 10 MB'
        ]);

        //ini kalo input angkanya null, di set ke 0
        if (is_null($request->itemStock)) {
            $item->stocks = 0;
        } else {
            $request->validate([
                'itemStock' => 'max:2147483647|min:0|numeric'
            ], [
                'itemStock.max' => 'Stok melebihi 32 bit integer (2147483647)',
                'itemStock.min' => 'Stok tidak boleh angka negatif',
                'itemStock.numeric' => 'input stok harus angka'
            ]);
            $item->stocks = $request->itemStock;
        }

        // $file = $request->file('itemImage');
        // $imageName = time() . '.' . $file->getClientOriginalExtension();
        // Storage::putFileAs('public/itemImages', $file, $imageName);
        // $imageName = 'itemImages/' . $imageName;

        $file = $request->file('itemImage');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $destination = public_path('storage\itemImages') . '\\' . $imageName;

        $data = getimagesize($file);
        $width = $data[0];
        $height = $data[1];
        // dd($width . ' ' . $height);
        // image resizing with "Image Intervention"
        if ($width > $height) {
            $resize_image = Image::make($file->getRealPath())->resize(
                1920,
                1080
            )->save($destination);
        } else {
            $resize_image = Image::make($file->getRealPath())->resize(
                1080,
                1920
            )->save($destination);
        }
        $resize_image->save($destination);
        // image resizing with "Image Intervention" end line of code
        $imageName = 'itemImages/' . $imageName;

        $item->item_id = $request->itemid;
        // ini pada kurang validasi, terutama angkanya tuh, harus pake php biar validasi manual kyknya, sebenernhya kyknya sihudah bisa sama html, tp ya validasi aja lg
        $item->brand_id = $request->brandidforitem;
        $item->item_name = $request->itemname;
        $item->item_pictures = $imageName;
        $item->customer_id = $customer->customer_id;

        $item->save();
        $request->session()->flash('sukses_addNewItem', $request->itemname);
        return redirect()->back();
    }

    public function manage_item_page()
    {
        $item = Item::all();
        $customer = Customer::all();
        $brand = Brand::all();
        return view('manage_views.manageItem', compact('item', 'customer', 'brand'));
    }

    public function item_history_page()
    {
        session()->forget('deleteFilterButton');

        $user = Auth::user();

        // sementara
        $history = StockHistory::all();
        $item = Item::all();

        // if ($user->level == 'admin') {
        //     $history = StockHistory::all();
        //     $item = Item::all();
        //     // dd($item);
        // } else {
        //     $history = DB::table('stock_histories')
        //         ->join('items', 'stock_histories.item_id', '=', 'items.item_id')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->select('stock_histories.*')
        //         ->where('user_id', $user->id)->get();


        //     $item = DB::table('items')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->select('items.item_name', 'items.item_id', 'items.id')
        //         ->where('user_id', $user->id)->get();
        // }

        return view('history_views.itemHistory', compact('history', 'item'));
    }

    public function deleteItem($id)
    {
        try {
            $decrypted = decrypt($id);
        } catch (DecryptException $e) {
            abort(403);
        }


        $itemIncoming = Incoming::where('item_id', $decrypted)->first();
        $itemOutgoing = Outgoing::where('item_id', $decrypted)->first();
        $item = Item::find($decrypted);
        $deletedItem = $item->item_name;

        if (is_null($itemIncoming) && is_null($itemOutgoing)) {
            Storage::delete('public/' . $item->item_pictures);
            $item->delete();
            $itemDeleted = "Barang" . " \"" . $deletedItem . "\" " . "berhasil di hapus";
            session()->flash('sukses_delete_item', $itemDeleted);
            return redirect()->back();
        } else {
            session()->flash('gagal_delete_item', 'Item' . " \"" . $deletedItem . "\" " . 'Gagal Dihapus karena sudah mempunyai Sejarah Incoming/Outgoing');
            return redirect()->back();
        }
    }

    public function updateItem(Request $request)
    {
        // kalo ada data yang dimasukin
        if ($request->file('itemImage') || $request->itemnameformupdate) {

            $itemInfo = Item::where('item_id', $request->itemIdHidden)->first();

            $file = $request->file('itemImage');


            // validasi data buat mastiin nggak null
            if ($file != null) {
                $request->validate([
                    'itemImage' => 'mimes:jpeg,png,jpg|max:10240',
                ], [
                    'itemImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png',
                    'itemImage.max' => 'Ukuran foto harus dibawah 10 MB'
                ]);
            }
            if ($request->itemnameformupdate != null) {
                $request->validate([
                    'itemnameformupdate' => 'unique:App\Models\Item,item_name|min:3|max:75|regex:/^[\pL\s\-\0-9]+$/u', //updated to include numbers
                ], [
                    'itemnameformupdate.unique' => 'Nama Barang yang diisi sudah terambil, masukkan nama yang lain',
                    'itemnameformupdate.min' => 'Nama Barang minimal 3 karakter',
                    'itemnameformupdate.max' => 'Nama Barang maksimal 75 karakter',
                    'itemnameformupdate.regex' => 'Nama Barang hanya membolehkan huruf, angka, spasi, dan tanda penghubung(-)',
                ]);
            }


            // buat update image
            if ($file != null) {
                // dd("ms");
                $request->validate([
                    'itemImage' => 'mimes:jpeg,png,jpg',
                ], [
                    'itemImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png'
                ]);

                // $imageName = time() . '.' . $file->getClientOriginalExtension();
                // Storage::putFileAs('public/itemImages', $file, $imageName);
                // $imageName = 'itemImages/' . $imageName;

                //
                $imageName = time() . '.' . $file->getClientOriginalExtension();
                $destination = public_path('storage\itemImages') . '\\' . $imageName;

                $data = getimagesize($file);
                $width = $data[0];
                $height = $data[1];
                // dd($width . ' ' . $height);
                // image resizing with "Image Intervention"
                if ($width > $height) {
                    $resize_image = Image::make($file->getRealPath())->resize(
                        1920,
                        1080
                    )->save($destination);
                } else {
                    $resize_image = Image::make($file->getRealPath())->resize(
                        1080,
                        1920
                    )->save($destination);
                }
                $resize_image->save($destination);
                // image resizing with "Image Intervention" end line of code
                $imageName = 'itemImages/' . $imageName;
                //

                Storage::delete('public/' . $itemInfo->item_pictures);

                Item::where('item_id', $request->itemIdHidden)->update([
                    'item_pictures' => $imageName,
                ]);
            } else {
                // dd("lha");
                Item::where('item_id', $request->itemIdHidden)->update([
                    'item_pictures' => $itemInfo->item_pictures,
                ]);
            }

            // buat update nama
            if ($request->itemnameformupdate != null) {


                Item::where('item_id', $request->itemIdHidden)->update([
                    'item_name' => $request->itemnameformupdate,
                ]);

                $request->session()->flash('sukses_editItem', $request->itemnameformupdate);
            } else {
                $oldItemName = $itemInfo->item_name;

                $request->session()->flash('sukses_editItem', $oldItemName);
            }
        } else {
            $request->session()->flash('noData_editItem', 'tidak ada');
        }

        return redirect()->back();
    }

    public function exportCustomerItem(Request $request)
    {
        $customer = Customer::find($request->customerItemExport);

        $sortItem = Item::all()->where('customer_id', $request->customerItemExport);

        return Excel::download(new editItemExport($sortItem), 'Item milik Customer ' .  $customer->customer_name . '.xlsx');
    }

    public function exportBrandItem(Request $request)
    {
        $brand = Brand::find($request->brandItemExport);

        $sortItem = Item::all()->where('brand_id', $request->brandItemExport);

        return Excel::download(new editItemExport($sortItem), 'Item milik Brand ' .  $brand->brand_name . '.xlsx');
    }

    public function item_report_page()
    {
        // session()->forget('deleteFilterButton'); //ini buat tombol filter yang ga jadi digunain

        $incoming = Incoming::all();
        $customer = Customer::all();
        $item = Item::all();
        $brand = Brand::all();
        return view('report_views.itemReport', compact('incoming', 'brand', 'customer', 'item'));

        // $user = Auth::user();

        // $pallet = DB::table('pallets')
        //     ->join('items', 'pallets.item_id', '=', 'items.item_id')
        //     ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
        //     ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
        //     ->select('pallets.*', 'items.item_name', 'items.item_id', 'customer.customer_id', 'customer.customer_name', 'brand.brand_name', 'items.item_pictures')
        //     ->get();

        // $brand = DB::table('brand')
        //     ->join('customer', 'brand.customer_id', '=', 'customer.customer_id')
        //     ->select('brand.brand_name', 'brand.brand_id')->get();

        // if ($user->level == 'admin') {
        //     $pallet = DB::table('pallets')
        //         ->join('items', 'pallets.item_id', '=', 'items.id')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('brand', 'items.brand_id', '=', 'brand.id')
        //         // ->select('pallets.*', 'items.item_name', 'items.item_id')
        //         ->select('pallets.*', 'items.item_name', 'items.item_id', 'customer.id as customer_id', 'customer.customer_name', 'brand.brand_name', 'items.item_pictures')
        //         ->get();
        //     // dd($pallet);

        //     // $item = DB::table('items')
        //     //     ->join('customer', 'items.customer_id', '=', 'customer.id')
        //     //     ->select('items.item_name', 'items.item_id', 'items.id')->get();

        //     $brand = DB::table('brand')
        //         ->join('customer', 'brand.customer_id', '=', 'customer.id')
        //         ->select('brand.brand_name', 'brand.brand_id')->get();
        // } else {
        //     $pallet = DB::table('pallets')
        //         ->join('items', 'pallets.item_id', '=', 'items.id')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('brand', 'items.brand_id', '=', 'brand.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->select('pallets.*', 'items.item_name', 'items.item_id', 'customer.id as customer_id', 'customer.customer_name', 'user_accesses.user_id', 'brand.brand_name', 'items.item_pictures')
        //         ->where('user_id', $user->id)->get();
        //     // dd($pallet);

        //     // $brand = DB::table('items')
        //     //     ->join('customer', 'items.customer_id', '=', 'customer.id')
        //     //     ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //     //     ->select('items.item_name', 'items.item_id', 'items.id')
        //     //     ->where('user_id', $user->id)->get();

        //     $brand = DB::table('brand')
        //         ->join('customer', 'brand.customer_id', '=', 'customer.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'brand.customer_id')
        //         ->select('brand.brand_name', 'brand.brand_id')
        //         ->where('user_id', $user->id)->get();
        // }

        // return view('report_views.itemReport', compact('brand', 'pallet'));
    }

    // public function exportItemReport(Request $request)
    // {
    //     $sortCustomerReport = DB::table('pallets')
    //         ->join('items', 'items.id', '=', 'pallets.item_id') //integer
    //         ->join('customer', 'items.customer_id', '=', 'customer.id')
    //         ->join('brand', 'items.brand_id', '=', 'brand.id')
    //         ->select('pallets.*', 'items.item_name', 'items.item_id', 'customer.id as customer_id', 'customer.customer_name', 'brand.brand_name', 'items.item_pictures', 'brand.brand_id')
    //         ->where('brand.brand_id', $request->itemIdReportCustomer)->get();

    //     // dd($sortCustomerReport);

    //     // return Excel::download(new CustomerReportExport($sortCustomerReport), 'Laporan Customer' . $sortCustomerReport->customer_name . '.xlsx');
    //     return Excel::download(new CustomerReportExport($sortCustomerReport), 'Laporan Customer' . '.xlsx');
    // }

    public function exportItemReportCustomer(Request $request)
    {
        $customer = Customer::find($request->customerIdItemReport);

        $sortAll = DB::table('incomings')
            ->join('customer', 'incomings.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'incomings.brand_id', '=', 'brand.brand_id')
            ->join('items', 'incomings.item_id', '=', 'items.item_id')
            ->select('incomings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
            ->where('incomings.customer_id', $request->customerIdItemReport)->get();

        $formatFileName = 'Laporan Stok by pcs Customer ' . $customer->customer_name;
        return Excel::download(new ItemReportExport($sortAll), $formatFileName . '.xlsx');
    }

    public function exportItemReportBrand(Request $request)
    {
        $brand = Brand::find($request->brandIdItemReport);

        $sortAll = DB::table('incomings')
            ->join('customer', 'incomings.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'incomings.brand_id', '=', 'brand.brand_id')
            ->join('items', 'incomings.item_id', '=', 'items.item_id')
            ->select('incomings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
            ->where('incomings.brand_id', $request->brandIdItemReport)->get();

        $formatFileName = 'Laporan Stok by pcs Brand ' . $brand->brand_name;
        return Excel::download(new ItemReportExport($sortAll), $formatFileName . '.xlsx');
    }

    public function exportItemReportItem(Request $request)
    {
        $item = Item::find($request->itemIdItemReport);

        $sortAll = DB::table('incomings')
            ->join('customer', 'incomings.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'incomings.brand_id', '=', 'brand.brand_id')
            ->join('items', 'incomings.item_id', '=', 'items.item_id')
            ->select('incomings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
            ->where('incomings.item_id', $request->itemIdItemReport)->get();

        $formatFileName = 'Laporan Stok by pcs Barang ' . $item->item_name;
        return Excel::download(new ItemReportExport($sortAll), $formatFileName . '.xlsx');
    }

    public function exportItemReportDate(Request $request)
    {
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $sortAll = DB::table('incomings')
            ->join('customer', 'incomings.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'incomings.brand_id', '=', 'brand.brand_id')
            ->join('items', 'incomings.item_id', '=', 'items.item_id')
            ->select('incomings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
            ->whereBetween('arrive_date', [$date_from, $date_to])->get();

        $formatFileName = 'Laporan Stok by pcs ALL ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");
        return Excel::download(new ItemReportExport($sortAll), $formatFileName . '.xlsx');
    }
}
