<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

// Hapus impor ini jika file RouteServiceProvider.php memang tidak ada:
// use Illuminate\Foundation\Support\Providers\RouteServiceProvider; 


class RedirectIfAuthenticated
{
    /**
     * ...
     */
   public function handle(Request $request, Closure $next, string ...$guards): Response
{
    if (Auth::check()) {

        $user = Auth::user();

        // Redirect hanya jika user membuka halaman login/register (GET)
        if ($request->isMethod('get') && ($request->is('login') || $request->is('register'))) {

            return $user->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('home');
        }
    }

    return $next($request);
}


}