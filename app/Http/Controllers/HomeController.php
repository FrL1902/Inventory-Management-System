<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        // $personal = User::where('id', '=', $request->id)->first();
        // return view('home', compact('personal'));
        return view('home');
    }
}
