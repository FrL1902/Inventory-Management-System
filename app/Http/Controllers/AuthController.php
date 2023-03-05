<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function cek_login(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'Email harus diisi',
            'password.required' => 'password harus diisi'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($credentials)){
            // return 'sukses';
            return redirect(route('home'));
        }

        else{
            return 'Gagal. Informasi yang dimasukkan salah';
        }
    }

    public function logout()
    {
        //CLEAR SESSION
        //LOGOUT AUTH
        Auth::logout();
        return redirect('/');
    }

}
