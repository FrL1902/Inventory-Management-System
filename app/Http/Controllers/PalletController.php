<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pallet;
use App\Models\PalletHistory;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PalletController extends Controller
{
    public function manage_pallet_page()
    {
        $pallet = Pallet::all();
        $item = Item::all();
        return view('managePallet', compact('pallet', 'item'));
    }

    public function add_pallet(Request $request)
    {
        $itemInfo = Item::where('id', $request->itemidforpallet)->first();
        $totalInPalletCurrently = Pallet::where('item_id', $request->itemidforpallet)->sum('stock'); //INI BISA DAPET TOTALNYA

        // stok total yg di palet pada suatu item tidak boleh melebihi stok item di tabel items
        $availableStock = $itemInfo->stocks - $totalInPalletCurrently;

        // dd($availableStock);
        if ($availableStock < $request->palletStock) {
            session()->flash('gagalMasukPaletVALUE', 'stok ke palet melebihi stok barang');
            return redirect()->back();
        }

        $request->validate([
            'palletDesc' => 'min:1|max:50',
            'bin' => 'max:10'
        ], [
            'palletDesc.min' => 'Deskripsi minimal 1 karakter',
            'palletDesc.max' => 'Deskripsi maksimal 50 karakter',
            'bin.max' => 'BIN maksimal 10 karakter',
        ]);

        // memasukkan data ke tabel palet
        $pallet = new Pallet();
        $pallet->item_id = $request->itemidforpallet;
        $pallet->stock = $request->palletStock;
        $pallet->bin = $request->bin;
        $pallet->description = $request->palletDesc;

        $pallet->save();


        // memasukkan data ke tabel sejarah palet
        $history = new PalletHistory();
        $history->item_id = $request->itemidforpallet;
        $history->stock = $request->palletStock;
        $history->bin = $request->bin;
        $history->status = 'DALAM INVENTORY';
        $history->user = $request->userIdHidden;

        $history->save();

        session()->flash('suksesMasukPaletVALUE', 'Stok barang dimasukkan ke palet');

        return redirect()->back();
    }

    public function reduce_pallet_stock(Request $request)
    {
        $palletInfo = Pallet::where('id', $request->palletIdHidden)->first();
        $id = Auth::user()->id;

        if ($palletInfo->stock < $request->palletStockOut) {
            session()->flash('gagalStokPalletKeluar', 'stok yang ingin dikeluarkan lebih besar dari stok di palet');
            return redirect()->back();
        } else if ($palletInfo->stock == $request->palletStockOut) { //ini kalau keluar semua stoknya
            $palletInfo->delete();

            // memasukkan data ke tabel sejarah palet
            $history = new PalletHistory();
            $history->item_id = $palletInfo->item_id;
            $history->stock = $palletInfo->stock;
            $history->bin = $palletInfo->bin;
            $history->status = 'KELUAR';
            $history->user = $id;

            $history->save();

            session()->flash('suksesPaletKeluar', 'Barang Berhasil Dikeluarkan dari Palet');
            return redirect()->back();
        } else if ($palletInfo->stock > $request->palletStockOut) { //ini kalau keluar sebagian stoknya
            $newValue = $palletInfo->stock - $request->palletStockOut;

            // memasukkan data ke tabel sejarah palet
            $history = new PalletHistory();
            $history->item_id = $palletInfo->item_id;
            $history->stock = $newValue;
            $history->bin = $palletInfo->bin;
            $history->status = 'KELUAR SEBAGIAN ' . '(' . (string)$request->palletStockOut . ')';
            $history->user = $id;

            Pallet::where('id', $request->palletIdHidden)->update([
                'stock' => $newValue
            ]);

            $history->save();

            session()->flash('suksesPaletKeluar2', 'Barang Berhasil Dikeluarkan Sebanyak ' . $request->palletStockOut);
            return redirect()->back();
        }
    }

    public function remove_pallet($id)
    {
        try {
            $decrypted = decrypt($id);
        } catch (DecryptException $e) {
            abort(403);
        }
        $palletInfo = Pallet::where('id', $decrypted)->first();
        $id = Auth::user()->id;

        // dd($palletInfo->stock);


        $palletInfo = Pallet::where('id', $decrypted)->first();

        $palletInfo->delete();

        // memasukkan data ke tabel sejarah palet
        $history = new PalletHistory();
        $history->item_id = $palletInfo->item_id;
        $history->stock = $palletInfo->stock;
        $history->bin = $palletInfo->bin;
        $history->status = 'KELUAR';
        $history->user = $id;

        $history->save();

        session()->flash('suksesPaletKeluar', 'Barang Berhasil Dikeluarkan dari Palet');
        return redirect()->back();
    }

    public function manage_pallet_history_page()
    {
        // $palletHistory = PalletHistory::all();
        $palletHistory = DB::table('pallet_histories')
            ->join('items', 'pallet_histories.item_id', '=', 'items.id') //join('tabel yang mau di tambahin', 'tabel utama.value yang mau dicocokin', '=', 'tabel yang ditambahin.value yang mau dicocokin')
            ->join('users', 'pallet_histories.user', '=', 'users.id') //bagian join bisa dilakuin berkali kali
            ->select('pallet_histories.*', 'items.item_name', 'users.name')->get(); //jgn lupa manggil semua tabel utamanya terus ditambah lagi kolom yang diinginkan
        // dd($palletHistory);
        return view('palletHistory', compact('palletHistory'));


        // $users = DB::table('users')
        //     ->join('contacts', 'users.id', '=', 'contacts.user_id')
        //     ->join('orders', 'users.id', '=', 'orders.user_id')
        //     ->select('users.*', 'contacts.phone', 'orders.price')
        //     ->get();
    }
}
