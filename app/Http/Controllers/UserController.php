<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\Customer;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{
    public function new_user_page()
    {
        return view('admin.newUser');
    }

    public function manage_user_page()
    {
        $user = User::all();
        $customer = Customer::all();

        return view('admin.manageUser', compact('user', 'customer'));
    }

    // public function update(Request $request)
    // {

    //     dd($request->userIdHidden);
    // }

    public function makeUser(Request $request)
    {
        $request->validate([
            'usernameform' => 'required|unique:App\Models\User,name|min:4|max:50',
            'emailform' => 'required|unique:App\Models\User,email',
            'passwordform' => 'required|min:6|max:20',
            'optionsRadios' => 'required'
        ], [
            'usernameform.unique' => 'Username sudah terambil, masukkan username yang berbeda',
            'usernameform.min' => 'Username minimal 4 karakter',
            'usernameform.max' => 'Username maksimal 50 karakter',
            'emailform.unique' => 'Email sudah terambil, masukkan email yang berbeda',
            'passwordform.min' => 'Password minimal 6 karakter',
            'passwordform.max' => 'Password maksimal 20 karakter',
            'optionsRadios.required' => 'Kolom "Role" harus dipilih',
        ]);

        $account = new User();
        $account->name = $request->usernameform;
        $account->email = $request->emailform;
        $account->level = $request->optionsRadios;
        $account->password = Hash::make($request->passwordform);
        $account->pass = $request->passwordform;

        $account->save();

        if($request->optionsRadios == "customer"){
            $access = new UserAccess();
            $access->user_id = $request->usernameform;
            $access->customer_id = 0;
            $access->save();
        }

        $userAdded = $request->usernameform . " [" . $request->optionsRadios . "] " . "berhasil di tambahkan";
        $request->session()->flash('sukses_add', $userAdded);

        return redirect()->back();

        // return $request->input();
    }

    public function destroy($id)
    {
        try {
            $decrypted = decrypt($id);
        } catch (DecryptException $e) {
            abort(403);
        }

        $user = User::find($decrypted);

        $deletedUser = $user->name;

        $user->delete();

        $userDeleted = "User" . " \"" . $deletedUser . "\" " . "berhasil di hapus";

        session()->flash('sukses_delete', $userDeleted);

        return redirect()->back();
    }


    public function tex(Request $request)
    {
        $userInfo = User::where('id', $request->userIdHidden)->first();
        $oldUsername = $userInfo->name;

        $request->validate([
            'usernameformupdate' => 'required|unique:App\Models\User,name|min:4|max:16',
        ]);

        User::where('id', $request->userIdHidden)->update([
            'name' => $request->usernameformupdate,
        ]);

        $request->session()->flash('sukses_editUser', $oldUsername);

        return redirect()->back();
    }

    public function user_access_page($id)
    {
        // dd($id);
        try {
            $decrypted = decrypt($id);
        } catch (DecryptException $e) {
            abort(403);
        }

        $user = User::find($decrypted);
        $customer = Customer::all();
        // $access = UserAccess::where('user_id', $id)->get();
        $access = DB::table('user_accesses')->join('customer', 'user_accesses.customer_id', '=', 'customer.id')->select('user_accesses.*', 'customer.customer_name', 'customer.customer_id')->where('user_id', $decrypted)->get();

        // palletHistory = DB::table('pallet_histories')
        //     ->join('items', 'pallet_histories.item_id', '=', 'items.id') //join('tabel yang mau di tambahin', 'tabel utama.value yang mau dicocokin', '=', 'tabel yang ditambahin.value yang mau dicocokin')
        //     ->join('users', 'pallet_histories.user', '=', 'users.id') //bagian join bisa dilakuin berkali kali
        //     ->select('pallet_histories.*', 'items.item_name', 'users.name')->get(); //jgn lupa manggil semua tabel utamanya terus ditambah lagi kolom yang diinginkan

        // dd($access);


        return view('admin.userAccess', compact('user', 'customer', 'access'));
    }

    public function add_new_user_access(Request $request) //ini juga harus pake name //ntar aja tapi ini mah, fiturnya ga dipake soalnya
    {
        // dd($request->userIdHidden);
        $exist = UserAccess::where('user_id', 'LIKE', $request->userIdHidden)->where('customer_id', 'LIKE', $request->customerforaccess)->first();
        // dd($exist->customer_id);
        if (is_null($exist)) {
            // dd('y');
            $access = new UserAccess();
            $access->user_id = $request->userIdHidden;
            $access->customer_id = $request->customerforaccess;
            $access->save();
            // dd('y');
            $request->session()->flash('userAccessSuccess', 'Sukses memberikan akses ke user');
            return redirect()->back();
        } else {
            // dd('user sudah punya akses ke customer ini');
            $request->session()->flash('akses_already_there', 'user sudah punya akses ke customer ini');
            return redirect()->back();
        }
    }

    public function exportExcel(Request $request)
    {
        // dd($request->userLevel);
        return Excel::download(new UserExport, 'User Warehouse.xlsx');
        // return (new UserExport())->download('User Warehouse.xlsx');
        // return (new UserExport($request->userLevel, $request->startRange, $request->endRange))->download('User Warehouse.xlsx');
    }

    public function newPasswordFromAdmin(Request $request)
    {
        // $tes = User::where('id', 321)->first();
        // dd('masok cok');
        // dd(is_null($tes));
        // dd($request->userIdHidden);

        $getUser = User::where('id', $request->userIdHidden)->first();

        // dd($getUser->name);

        if ($request->changePassword === $request->changePassword2) {
        } else {
            $request->session()->flash('passwordInputDifferent', 'Update Gagal: password baru harus sesuai di kedua kolom');
            return redirect()->back();
        }

        // validasi panjang karakter password
        $request->validate([
            'changePassword' => 'min:6|max:20',
        ]);

        // validasi password baru tidak boleh sama dari password lama
        if (Hash::check($request->changePassword, $getUser->password)) { //mungkin ganti ke bcrypt kali yak
            $request->session()->flash('passwordSameOld', 'Update Gagal: password baru harus berbeda dari password lama');
            return redirect()->back();
        } else {
            User::where('id',  $getUser->id)->update([
                'password' => Hash::make($request->changePassword),
                'pass' => $request->changePassword,
            ]);
            $request->session()->flash('passwordUpdated', 'Update Berhasil: password berhasil diubah');
            return redirect()->back();
        }
    }

    public function delete_user_access($id)
    {
        try {
            $decrypted = decrypt($id);
        } catch (DecryptException $e) {
            abort(403);
        }
        // dd($decrypted);

        $access = UserAccess::find($decrypted);

        $access->delete();

        session()->flash('deletedAccess', 'Akses user berhasil di hapus');

        return redirect()->back();
    }

    public function customer_assign(Request $request) //ini harus pake user name
    {
        // dd($request->userIdHidden);
        // dd($request->customeridforassign);
        if($request->customeridforassign == 0){ //ini buat akses semua
            $delete = UserAccess::where('user_id', 'LIKE', $request->userIdHidden)->first();
            if (!is_null($delete)) {
                $delete->delete();
            }
            $access = new UserAccess();
            $access->user_id = $request->userIdHidden;
            $access->customer_id = 0;
            $access->save();

            $request->session()->flash('userAccessSuccess', 'Sukses: Customer punya akses semua data');
            return redirect()->back();
        }

        // dd($request->userIdHidden);
        $exist = UserAccess::where('user_id', 'LIKE', $request->userIdHidden)->where('customer_id', 'LIKE', $request->customeridforassign)->first();
        // dd($exist->customer_id);
        if (is_null($exist)) {
            // dd('y');

            $delete = UserAccess::where('user_id', 'LIKE', $request->userIdHidden)->first();
            if (!is_null($delete)) {
                // dd('s');
                $delete->delete();
            }
            $access = new UserAccess();
            $access->user_id = $request->userIdHidden;
            $access->customer_id = $request->customeridforassign;
            $access->save();


            // dd('y');

            $request->session()->flash('userAccessSuccess', 'Sukses assign customer');
            return redirect()->back();
        } else {
            // dd('user sudah punya akses ke customer ini');
            $request->session()->flash('akses_already_there', 'sudah punya akses ke customer ini');
            return redirect()->back();
        }
    }
}
