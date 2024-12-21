<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie('user_token');
       
        if ($token && Auth::check() && Auth::user()->remember_token === $token) {
              return $next($request);
        }

        // Arahkan ke halaman login jika token tidak ditemukan
        return redirect()->route('login.form')->with('message', 'Please log in to continue');
        
    }

}
