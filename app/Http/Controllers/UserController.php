<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function new_user_page()
    {
        return view('admin.newUser');
    }

    public function manage_user_page()
    {
        $user = User::all();

        return view('admin.manageUser', compact('user'));
    }

    public function makeUser(Request $request)
    {
        // $request->validate([
        //     'username' => 'required|unique:users|min:5',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|alpha_num|confirmed|min:6',
        // ]);

        // $request->validate([
        //     'Username' => 'min:10|unique:users',
        //     'email' => 'unique:users',
        //     'password' => 'min:6',
        // ]);

        // $request->validate([
        //     'name' => 'unique:users|min:6',
        //     'emailform' => 'unique:users',
        //     'passwordform' => 'min:6',
        // ]);

        // $rules = [
        //     'Usernameform' => 'unique:users|min:6',
        //     'emailform' => 'unique:users',
        //     'passwordform' => 'min:6',
        // ];

        // $validator = Validator::make($request->all(), $rules);

        // if ($validator->fails()) {
        //     return back()->withErrors($validator);
        // }


        // dd('tes');
        // User::create([
        //     'level' => $request->optionsRadios,
        //     'email' => $request->email,
        //     'name' => $request->username,
        //     'password' => Hash::make($request->password),
        // ]);

        $account = new User();
        $account->name = $request->usernameform;
        $account->email = $request->emailform;
        $account->level = $request->optionsRadios;
        $account->password = Hash::make($request->passwordform);

        $account->save();

        // return redirect()->back()->with('berhasil 1', 'berhasil 2');

        // return redirect()->with('berhasil 1', 'berhasil 2')->back();
        // Session::flash('alert', $request->emailform . ' has been deleted successfully!');
        // Session::flash('message', 'This is a message!');
        // $request->session()->flash('status', 'Task was successful!');
        return redirect()->back();

        // return $request->input();
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('manageUser');
    }
}
