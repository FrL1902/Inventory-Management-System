<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // $time = Carbon::Now();

        // echo $time;

        return view('home');
    }
}
