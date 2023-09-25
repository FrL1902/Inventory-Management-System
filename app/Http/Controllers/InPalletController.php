<?php

namespace App\Http\Controllers;

use App\Models\InPallet;
use App\Models\Item;
use App\Models\OutPallet;
use App\Models\Pallet;
use App\Models\PalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        // dd('123');
        $itemInfo = Item::where('item_id', $request->itemidforpallet)->first();
        $totalInPalletCurrently = InPallet::where('item_id', $request->itemidforpallet)->sum('stock'); //INI BISA DAPET TOTALNYA

        // stok total yg di palet pada suatu item tidak boleh melebihi stok item di tabel items
        $availableStock = $itemInfo->stocks - $totalInPalletCurrently;

        // dd($availableStock);
        if ($availableStock < $request->palletStock) {
            session()->flash('gagalMasukPaletVALUE', 'stok ke palet melebihi stok barang');
            return redirect()->back();
        }

        $request->validate([
            'palletDesc' => 'min:1|max:50',
            'bin' => 'max:10',
            'inPalletImage' => 'required|mimes:jpeg,png,jpg',
        ], [
            'palletDesc.min' => 'Deskripsi minimal 1 karakter',
            'palletDesc.max' => 'Deskripsi maksimal 50 karakter',
            'bin.max' => 'BIN maksimal 10 karakter',
            'inPalletImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png'
        ]);

        // memasukkan data ke tabel inpalet
        $inpallet = new InPallet();
        $inpallet->item_id = $request->itemidforpallet;
        $inpallet->user_date = $request->palletArrive;
        $inpallet->stock = $request->palletStock;
        $inpallet->bin = $request->bin;
        $inpallet->description = $request->palletDesc;

        $file = $request->file('inPalletImage');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs('public/inPalletImage', $file, $imageName);
        $imageName = 'inPalletImage/' . $imageName;
        $inpallet->item_pictures = $imageName;

        $inpallet->save();


        // memasukkan data ke tabel sejarah palet
        $history = new PalletHistory();
        // $history->item_id = $request->itemidforpallet;
        $history->item_id = $itemInfo->item_id;
        $history->stock = $request->palletStock;
        $history->bin = $request->bin;
        $history->status = 'DALAM INVENTORY';
        $history->user = $request->userIdHidden;
        $history->user_date = $request->palletArrive;

        $history->save();

        session()->flash('suksesMasukPaletVALUE', 'Stok barang dimasukkan ke palet');

        return redirect()->back();
    }

    public function reduce_pallet_stock(Request $request)
    {
        $palletInfo = InPallet::where('id', $request->palletIdHidden)->first();

        $itemInfo = DB::table('inpallet')
            ->join('items', 'items.item_id', '=', 'inpallet.item_id')
            ->select('items.*')->where('inpallet.id', $request->palletIdHidden)->first();

        $id = Auth::user()->id;

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
            $history->user = $id;
            $history->user_date = $request->palletDepart;


            // outpallet
            $outPallet = new OutPallet();
            $outPallet->item_id = $itemInfo->item_id;
            $outPallet->user_date = $request->palletDepart;
            $outPallet->stock = $palletInfo->stock;
            $outPallet->bin = $palletInfo->bin;
            $outPallet->description = $request->palletDesc;

            $file = $request->file('outPalletImage');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/outPalletImage', $file, $imageName);
            $imageName = 'outPalletImage/' . $imageName;
            $outPallet->item_pictures = $imageName;


            $history->save();
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
            $history->user = $id;
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

            $file = $request->file('outPalletImage');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/outPalletImage', $file, $imageName);
            $imageName = 'outPalletImage/' . $imageName;
            $outPallet->item_pictures = $imageName;

            $outPallet->save();


            session()->flash('suksesPaletKeluar2', 'Barang Berhasil Dikeluarkan Sebanyak ' . $request->palletStockOut);
            return redirect()->back();
        }
    }
}
