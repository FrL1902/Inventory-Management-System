<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->level == 'admin') {
            $customer = DB::table('customer')->count();
            $brand = DB::table('brand')->count();
            $item = DB::table('items')->count();
        } else {
            $customer = DB::table('customer')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'customer.customer_id')
                ->select('customer.customer_id')
                ->where('user_id', $user->name)->count();
            $brand = DB::table('brand')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'brand.customer_id')
                ->select('brand.brand_id')
                ->where('user_id', $user->name)->count();
            $item = DB::table('items')
                ->join('customer', 'customer.customer_id', '=', 'items.customer_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->join('brand', 'brand.brand_id', '=', 'items.brand_id')
                ->select('items.item_id')
                ->where('user_id', $user->name)->count();
        }

        return view('home', compact('customer', 'brand', 'item'));
    }
}
