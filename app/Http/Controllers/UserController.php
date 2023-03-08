<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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


        // dd('tes');
        // User::create([
        //     'level' => $request->optionsRadios,
        //     'email' => $request->email,
        //     'name' => $request->username,
        //     'password' => Hash::make($request->password),
        // ]);

        $account = new User();
        $account->name = $request->username;
        $account->email = $request->email;
        // $account->level = 'admin';
        $account->level = $request->optionsRadios;
        $account->password = Hash::make($request->password);

        $account->save();

        // // return view('admin.manageUser');

        // $page = $this->manage_user_page();
        // return $page;
        // return view('admin.newUser');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('manageUser');
    }
}
