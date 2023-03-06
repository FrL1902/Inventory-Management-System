<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function manage_customer_page()
    {
        // $user = User::all();

        // return view('admin.manageUser', compact('user'));

        return view('manageCustomer');
    }

    public function new_customer_page()
    {
        return view('newCustomer');
    }
}
