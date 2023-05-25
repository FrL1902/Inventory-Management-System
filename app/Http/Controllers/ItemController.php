<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function new_item_page()
    {
        return view('newItem');
    }
}
