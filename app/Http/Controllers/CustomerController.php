<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function manage_customer_page()
    {
        $customer = Customer::all();

        return view('manageCustomer', compact('customer'));
    }

    public function new_customer_page(Request $request)
    {
        return view('newCustomer');
    }

    public function makeCustomer(Request $request)
    {
        $customer = new Customer();
        // dd('masuk');

        $customer->customer_id = $request->customerid;
        $customer->customer_name = $request->customername;
        $customer->address = $request->address;
        $customer->email = $request->email;
        $customer->phone1 = $request->phone1;
        $customer->phone2 = $request->phone2;
        $customer->fax = $request->fax;
        $customer->website = $request->website;
        $customer->pic = $request->picname;
        $customer->pic_phone = $request->picnumber;
        $customer->npwp_perusahaan = $request->npwp;

        // $data->customer_id = "asdflkjh";
        // $data->customer_name = "asdflkjh";
        // $data->address = "asdflkjh";
        // $data->email = "asdflkjh";
        // $data->phone1 = "asdflkjh";
        // $data->phone2 = "asdflkjh";
        // $data->fax = "asdflkjh";
        // $data->website = "asdflkjh";
        // $data->pic = "asdflkjh";
        // $data->pic_phone = "asdflkjh";
        // $data->npwp_perusahaan = "asdflkjh";

        $customer->save();


        // return view('newCustomer');
        return redirect()->back();
    }
}
