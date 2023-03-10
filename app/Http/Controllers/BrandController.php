<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    //
    public function new_brand_page()
    {

        return view('newBrand');
    }

    public function manage_brand_page()
    {

        return view('manageBrand');
    }
}
