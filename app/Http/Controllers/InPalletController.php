<?php

namespace App\Http\Controllers;

use App\Models\InPallet;
use App\Models\Item;
use App\Models\OutPallet;
use App\Models\Pallet;
use App\Models\PalletHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class InPalletController extends Controller
{
    //
    public function in_pallet_page()
    {
        // return view('inPallet');
        $inpallet = DB::table('inpallet')
            ->join('items', 'inpallet.item_id', '=', 'items.item_id')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
            ->select('inpallet.*', 'items.item_name', 'customer.customer_name', 'brand.brand_name')->get();
        // dd($pallet);

        $item = DB::table('items')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->select('items.item_name', 'items.item_id')->get();

        return view('inPallet', compact('inpallet', 'item'));
    }

    public function add_pallet(Request $request)
    {
        $request->validate([
            'itemidforpallet' => 'required',
            'palletStock' => 'required|max:2147483647|min:1|numeric',
            'bin' => 'required|max:10|regex:/^[A-Z0-9.]+$/u',
            'palletArrive' => 'required',
            'palletDesc' => 'required|min:1|max:50',
            'inPalletImage' => 'required|mimes:jpeg,png,jpg|max:10240',
        ], [
            'itemidforpallet.required' => 'Kolom "Nama Barang" harus dipilih',
            'palletStock.required' => 'Kolom "Stok" harus diisi',
            'palletStock.max' => 'Stok melebihi 32 bit integer',
            'palletStock.min' => 'Stok harus melebihi 1',
            'palletStock.numeric' => 'input stok harus angka',
            'bin.required' => 'Kolom "BIN" harus diisi',
            'bin.max' => 'BIN maksimal 10 karakter',
            'bin.regex' => 'BIN hanya menerima huruf kapital A-Z, titik (.), dan angka 0-9',
            'palletArrive.required' => 'Kolom "Tanggal Palet Masuk" harus diisi',
            'palletDesc.required' => 'Kolom "Keterangan" harus diisi',
            'palletDesc.min' => 'Deskripsi minimal 1 karakter',
            'palletDesc.max' => 'Deskripsi maksimal 50 karakter',
            'inPalletImage.required' => 'Kolom "Gambar Palet/Barang Datang" harus diisi',
            'inPalletImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png',
            'inPalletImage.max' => 'Ukuran foto harus dibawah 10 MB',
        ]);

        $itemInfo = Item::where('item_id', $request->itemidforpallet)->first();
        $totalInPalletCurrently = InPallet::where('item_id', $request->itemidforpallet)->sum('stock'); //INI BISA DAPET TOTAL STOK SUATU BARANG DI TABEL INPALLET
        $userInfo = User::where('id', $request->userIdHidden)->first();
        // dd($userInfo->name);

        // stok total yg di palet pada suatu item tidak boleh melebihi stok item di tabel items
        $availableStock = $itemInfo->stocks - $totalInPalletCurrently;

        if ($availableStock < $request->palletStock) {
            session()->flash('gagalMasukPaletVALUE', 'stok ke palet melebihi stok barang');
            return redirect()->back();
        }

        // memasukkan data ke tabel inpaletd
        $inpallet = new InPallet();
        $inpallet->item_id = $request->itemidforpallet;
        $inpallet->user_date = $request->palletArrive;
        $inpallet->stock = $request->palletStock;
        $inpallet->bin = $request->bin;
        $inpallet->description = $request->palletDesc;

        // $file = $request->file('inPalletImage');
        // $imageName = time() . '.' . $file->getClientOriginalExtension();
        // Storage::putFileAs('public/inPalletImage', $file, $imageName);
        // $imageName = 'inPalletImage/' . $imageName;

        $file = $request->file('inPalletImage');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $destination = public_path('storage\inPalletImage') . '\\' . $imageName;
        // dd(public_path());
        // dd($destination);

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
        // $resize_image->save($destination);
        // image resizing with "Image Intervention" end line of code
        $imageName = 'inPalletImage/' . $imageName;
        //


        $inpallet->item_pictures = $imageName;

        $inpallet->save();


        // memasukkan data ke tabel sejarah palet
        $history = new PalletHistory();
        // $history->item_id = $request->itemidforpallet;
        $history->item_id = $itemInfo->item_id;
        $history->stock = $request->palletStock;
        $history->bin = $request->bin;
        $history->status = 'DALAM INVENTORY';
        $history->user = $userInfo->name;
        $history->user_date = $request->palletArrive;

        $history->save();

        session()->flash('suksesMasukPaletVALUE', 'Stok barang dimasukkan ke palet');

        return redirect()->back();
    }

    public function reduce_pallet_stock(Request $request)
    {
        $request->validate([
            'palletStockOut' => 'required|max:2147483647|min:1|numeric',
            'palletDepart' => 'required',
            'palletDesc' => 'required|min:1|max:50',
            'outPalletImage' => 'required|mimes:jpeg,png,jpg|max:10240',
        ], [
            'palletStockOut.required' => 'Kolom "Stok" harus diisi',
            'palletStockOut.max' => 'Stok melebihi 32 bit integer',
            'palletStockOut.min' => 'Stok harus melebihi 1',
            'palletStockOut.numeric' => 'input stok harus angka',
            'palletDepart.required' => 'Kolom "Tanggal Palet Keluar" harus diisi',
            'palletDesc.required' => 'Kolom "Keterangan" harus diisi',
            'palletDesc.min' => 'Deskripsi minimal 1 karakter',
            'palletDesc.max' => 'Deskripsi maksimal 50 karakter',
            'outPalletImage.required' => 'Kolom "Gambar Palet/Barang Datang" harus diisi',
            'outPalletImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png',
            'outPalletImage.max' => 'Ukuran foto harus dibawah 10 MB',
        ]);

        $palletInfo = InPallet::where('id', $request->palletIdHidden)->first();

        $itemInfo = DB::table('inpallet')
            ->join('items', 'items.item_id', '=', 'inpallet.item_id')
            ->select('items.*')->where('inpallet.id', $request->palletIdHidden)->first();

        $id = Auth::user()->id;
        $userInfo = User::where('id', $id)->first();


        if ($palletInfo->stock < $request->palletStockOut) {
            session()->flash('gagalStokPalletKeluar', 'stok yang ingin dikeluarkan lebih besar dari stok di palet');
            return redirect()->back();
        } else if ($palletInfo->stock == $request->palletStockOut) { //ini kalau keluar semua stoknya
            Storage::delete('public/' . $palletInfo->item_pictures);
            $palletInfo->delete();

            // memasukkan data ke tabel sejarah palet
            $history = new PalletHistory();
            $history->item_id = $itemInfo->item_id;
            $history->stock = $palletInfo->stock;
            $history->bin = $palletInfo->bin;
            $history->status = 'KELUAR';
            $history->user = $userInfo->name;
            $history->user_date = $request->palletDepart;

            $history->save();

            // outpallet
            $outPallet = new OutPallet();
            $outPallet->item_id = $itemInfo->item_id;
            $outPallet->stock = $palletInfo->stock;
            $outPallet->bin = $palletInfo->bin;
            $outPallet->user_date = $request->palletDepart;
            $outPallet->description = $request->palletDesc;

            // $file = $request->file('outPalletImage');
            // $imageName = time() . '.' . $file->getClientOriginalExtension();
            // Storage::putFileAs('public/outPalletImage', $file, $imageName);
            // $imageName = 'outPalletImage/' . $imageName;

            $file = $request->file('outPalletImage');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('storage\outPalletImage') . '\\' . $imageName;

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
            // $resize_image->save($destination);
            // image resizing with "Image Intervention" end line of code
            $imageName = 'outPalletImage/' . $imageName;
            //


            $outPallet->item_pictures = $imageName;

            $outPallet->save();

            session()->flash('suksesPaletKeluar', 'Barang Berhasil Dikeluarkan dari Palet');
            return redirect()->back();
        } else if ($palletInfo->stock > $request->palletStockOut) { //ini kalau keluar sebagian stoknya
            $newValue = $palletInfo->stock - $request->palletStockOut;

            // memasukkan data ke tabel sejarah palet
            $history = new PalletHistory();
            $history->item_id = $itemInfo->item_id;
            $history->stock = $request->palletStockOut;
            $history->bin = $palletInfo->bin;
            $history->status = 'KELUAR SEBAGIAN ';
            $history->user = $userInfo->name;
            $history->user_date = $request->palletDepart;

            InPallet::where('id', $request->palletIdHidden)->update([
                'stock' => $newValue
            ]);

            $history->save();


            // outpallet
            $outPallet = new OutPallet();
            $outPallet->item_id = $itemInfo->item_id;
            $outPallet->user_date = $request->palletDepart;
            $outPallet->stock = $request->palletStockOut;
            $outPallet->bin = $palletInfo->bin;
            $outPallet->description = $request->palletDesc;

            // $file = $request->file('outPalletImage');
            // $imageName = time() . '.' . $file->getClientOriginalExtension();
            // Storage::putFileAs('public/outPalletImage', $file, $imageName);
            // $imageName = 'outPalletImage/' . $imageName;

            $file = $request->file('outPalletImage');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('storage\outPalletImage') . '\\' . $imageName;

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
            // $resize_image->save($destination);
            // image resizing with "Image Intervention" end line of code
            $imageName = 'outPalletImage/' . $imageName;
            //

            $outPallet->item_pictures = $imageName;

            $outPallet->save();


            session()->flash('suksesPaletKeluar2', 'Barang Berhasil Dikeluarkan Sebanyak ' . $request->palletStockOut);
            return redirect()->back();
        }
    }
}
