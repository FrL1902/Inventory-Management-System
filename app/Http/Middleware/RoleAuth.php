<?php

namespace App\Http\Middleware;

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
    public function handle(Request $request, Closure $next, ... $roles)
    {
        // Cek apakah user telah/masih login atau tidak. Jika tidak akan dibalikkan ke login page
        if (!Auth::check()){
            return redirect('/');
        }

    $user = Auth::user();

    // ADMIN BISA AKSES SEMUANYA (SUPERUSER IT)
    if($user->level == 'admin')
        return $next($request);

    // cek apakah user punya salah satu role dari yang diberi di parameter middleware
    foreach($roles as $role) {
        if($user->level == $role)
            return $next($request);
    }

    return abort(401);
    }
}
