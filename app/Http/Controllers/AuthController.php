<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function cek_login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'password harus diisi'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            // return 'sukses';
            // return redirect(route('/home'));
            return redirect('/');
        } else {
            // return 'Gagal. Informasi yang dimasukkan salah';
            // return redirect()->back()->withErrors('Gagal. informasi yang dimasukkan salah');
            // $failmsg = "informasi yang dimasukkan salah";
            $request->session()->flash('status', 'informasi yang dimasukkan salah');
            // return redirect('/loginPage');
            return redirect()->back();
        }
    }

    public function show_creds($id)
    {
        try {
            $decrypted = decrypt($id);
        } catch (DecryptException $e) {
            abort(403);
        }

        $user = User::where('id', $decrypted)->first();

        return view('changeUserCredential', compact(['user']));
    }

    public function updateUser(Request $request)
    {
        // validasi buat kedua kolom update password
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
        if (Hash::check($request->changePassword, auth()->user()->password)) { //mungkin ganti ke bcrypt kali yak
            $request->session()->flash('passwordSameOld', 'Update Gagal: password baru harus berbeda dari password lama');
            return redirect()->back();
        } else {
            User::where('id',  auth()->user()->id)->update([
                'password' => Hash::make($request->changePassword),
                'pass' => $request->changePassword,
            ]);
            $request->session()->flash('passwordUpdated', 'Update Berhasil: password berhasil diubah');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:5',
            'phone_number' => 'required|min:6|max:15',
        ]);

        return view('profile.profile', compact(['userInfo']));
    }

    public function logout()
    {
        //CLEAR SESSION
        //LOGOUT AUTH
        Auth::logout();
        return redirect('/');
    }
}
