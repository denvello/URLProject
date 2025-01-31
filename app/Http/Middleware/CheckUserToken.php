<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class CheckUserToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = Cookie::get('user_token');

        if (!$token) {
            // Token tidak ada, buat token baru
            $newToken = bin2hex(random_bytes(16));
            $hashedPassword = Hash::make('password123'); // Password default atau buat sistem pembuatan password

            // Simpan token dan password ke database
            User::create([
                'token' => $newToken,
                'password' => $hashedPassword,
            ]);

            // Set token ke cookie
            Cookie::queue('user_token', $newToken, 60 * 24 * 30); // 30 hari

            return redirect()->route('enter_password');
        }

        // Token ada, cek apakah ada di database
        $user = User::where('token', $token)->first();

        if ($user) {
            return redirect()->route('enter_password');
        }

        // Jika tidak ada token di database, buat yang baru
        return $next($request);
    }
}
