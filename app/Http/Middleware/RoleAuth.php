<?php

namespace App\Http\Middleware;

use App\Models\UserPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $page)
    // public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah user telah/masih login atau tidak (session habis atau tidak). Jika auth gagal, akan dibalikkan ke login page
        if (!Auth::check()) {
            return redirect('/');
        }

        // ini untuk page yang ga butuh special permission, tapi cuma harus login doang
        if ($page == 'auth') {
            return $next($request);
        }

        // untuk mengambil role user
        $user = Auth::user();

        // Ini untuk yang role admin bisa akses semua page
        if ($user->level == 'admin') {
            return $next($request);
        }

        // ini buat ngurus middleware bagian page admin, payloadnya 'admin_page' di middleware
        if ($page == 'admin_page' && $user->level == 'admin') {
            return $next($request);
        } else if ($page == 'admin_page' && $user->level != 'admin') {
            dd('masuk admin');
            return abort(401);
        }

        // paling bawah, validasi apakah user mempunyai akses ke page yang ingin dituju
        $pageStatus = UserPermission::where('name', $user->name)->where('page', $page)->first();
        if ($pageStatus->status == 1) {
            return $next($request);
        }

        // cek apakah user punya salah satu role dari yang diberi di parameter middleware || udah ngga dipake lagi
        // foreach ($roles as $role) {
        //     if ($user->level == $role)
        //         return $next($request);
        // }

        return abort(401);
    }
}
