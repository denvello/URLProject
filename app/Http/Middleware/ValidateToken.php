<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah ada token di cookie
        $token = $request->cookie('user_token');

        if ($token) {
            // Cari pengguna berdasarkan token
            $user = User::where('token', $token)->first();
            
            // Cek apakah pengguna ditemukan dan token belum kadaluarsa
            if ($user && $user->token_expired_at > now()) {
                // Token valid, simpan informasi pengguna ke request
                $request->merge(['user' => $user]);
                return $next($request); // Lanjutkan ke request berikutnya
            }
        }

        // Jika token tidak valid, redirect ke halaman login
        return redirect()->route('login');
    }
}