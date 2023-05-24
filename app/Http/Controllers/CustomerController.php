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

        // if (is_null($request->customername)) {
        //     dd("ini null cok");
        // }

        // validate the required inputs first
        $request->validate([
            'customerid' => 'required|unique:App\Models\Customer,customer_id|min:4|max:10',
            'customername' => 'required|min:4|max:30',
            'email' => 'required',
            'phone1' => 'required'
        ]);

        $customer = new Customer();

        // $customer->customer_id = $request->customerid;       yang dibutuhin ini
        // $customer->customer_name = $request->customername;   yang dibutuhin ini
        // $customer->address = $request->address;
        // $customer->email = $request->email;                  yang dibutuhin ini
        // $customer->phone1 = $request->phone1;                yang dibutuhin ini, work
        // $customer->phone2 = $request->phone2;
        // $customer->fax = $request->fax;
        // $customer->website = $request->website;
        // $customer->pic = $request->picname;
        // $customer->pic_phone = $request->picnumber;
        // $customer->npwp_perusahaan = $request->npwp;

        // check if input is null, set to "no-input"
        if (is_null($request->address)) {
            $customer->address = "no-input";
        } else {
            $customer->address = $request->address;
        }

        if (is_null($request->phone2)) {
            $customer->phone2 = "no-input";
        } else {
            $customer->phone2 = $request->phone2;
        }

        if (is_null($request->fax)) {
            $customer->fax = "no-input";
        } else {
            $customer->fax = $request->fax;
        }

        if (is_null($request->website)) {
            $customer->website = "no-input";
        } else {
            $customer->website = $request->website;
        }

        if (is_null($request->picname)) {
            $customer->pic = "no-input";
        } else {
            $customer->pic = $request->picname;
        }

        if (is_null($request->picnumber)) {
            $customer->pic_phone = "no-input";
        } else {
            $customer->pic_phone = $request->picnumber;
        }

        if (is_null($request->npwp)) {
            $customer->npwp_perusahaan = "no-input";
        } else {
            $customer->npwp_perusahaan = $request->npwp;
        }

        // input the required variables in
        $customer->customer_id = $request->customerid;
        $customer->customer_name = $request->customername;
        $customer->email = $request->email;
        $customer->phone1 = $request->phone1;

        $customer->save();

        $customerAdded = "Customer " . "\"" . $request->customername . "\"" . " berhasil di tambahkan";

        $request->session()->flash('sukses_addNewCustomer', $customerAdded);

        return redirect()->back();

        // return back()->withInput(); ini gak tau kenapa ga bisa, ya ga harus bgt sih tp sebagai Quality of Life aja
    }

    public function updateCustomer(Request $request)
    {
        // dd('yes');

        $customer = Customer::where('id', $request->customerIdHidden)->first();

        // dd($custInfo->customer_name);

        if (is_null($request->address)) {
        } else {
            $request->validate([
                'address' => 'min:4|max:100',
            ]);
            $customer->address = $request->address;
        }

        if (is_null($request->phone2)) {
        } else {
            $request->validate([
                'phone2' => 'min:4|max:30',
            ]);
            $customer->phone2 = $request->phone2;
        }

        if (is_null($request->fax)) {
        } else {
            $request->validate([
                'fax' => 'min:4|max:30',
            ]);
            $customer->fax = $request->fax;
        }

        if (is_null($request->website)) {
        } else {
            $request->validate([
                'website' => 'min:4|max:100',
            ]);
            $customer->website = $request->website;
        }

        if (is_null($request->picname)) {
        } else {
            $request->validate([
                'picname' => 'min:4|max:100',
            ]);
            $customer->pic = $request->picname;
        }

        if (is_null($request->picnumber)) {
        } else {
            $request->validate([
                'picnumber' => 'min:4|max:50',
            ]);
            $customer->pic_phone = $request->picnumber;
        }

        if (is_null($request->npwp)) {
        } else {
            $request->validate([
                'npwp' => 'min:4|max:100',
            ]);
            $customer->npwp_perusahaan = $request->npwp;
        }

        $customer->update();

        $customerUpdated = "Customer" . " \"" . $customer->customer_name . "\" " . "berhasil di update";

        session()->flash('sukses_update_customer', $customerUpdated);

        return redirect('manageCustomer');
    }

    public function deleteCustomer($id)
    {
        $cust = Customer::find($id);

        $deletedCustomer = $cust->customer_name;

        // dd($deletedCustomer);

        $cust->delete();

        $customerDeleted = "Customer" . " \"" . $deletedCustomer . "\" " . "berhasil di hapus";

        session()->flash('sukses_delete_customer', $customerDeleted);

        return redirect('manageCustomer');
    }
}
