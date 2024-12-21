<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\User;


class AuthController extends Controller

    {
        // Method untuk menampilkan form login atau melakukan pengecekan token
        public function showLoginForm(Request $request)
        {
            // Mengecek apakah ada token di cookie atau localStorage
            if ($request->hasCookie('user_token')) {
                $token = $request->cookie('user_token');
                $user = User::where('token', $token)->first();
                
                if ($user) {
                    // Token valid, lanjutkan dengan nama pengguna yang sesuai
                    return redirect()->route('dashboard')->with('username', $user->name);
                }
            }
    
            // Jika token tidak ada, tampilkan form login
            return view('login');
        }
    
        // Method untuk login dan generate token baru
        public function login(Request $request)
        {
            // Validasi input nama dan password
            $request->validate([
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8',
            ]);
    
            // Temukan user berdasarkan nama dan password
            $user = User::where('name', $request->input('name'))->first();
    
            if (!$user || !password_verify($request->input('password'), $user->password)) {
                return redirect()->back()->withErrors(['Invalid credentials']);
            }
    
            // Generate token pertama untuk disimpan di database
            $token = Str::random(64); // Token pertama
    
            // Update token ke database dan set waktu kadaluarsa token jika diperlukan
            $user->token = $token;
            $user->token_expired_at = now()->addDays(7); // Token expired setelah 7 hari
            $user->save();
    
            // Token kedua, simpan di cookie atau localStorage
            $cookie = cookie('user_token', $token, 60 * 24 * 7); // Cookie bertahan 7 hari
    
            // Redirect ke dashboard dan kirimkan cookie
            return redirect()->route('dashboard')->with('username', $user->name)->cookie($cookie);
        }
        
        // Method untuk logout
        public function logout()
        {
            // Hapus token dari session atau cookie
            Cookie::forget('user_token');
            session()->flush();
    
            return redirect()->route('login');
        }

        public function checkToken(Request $request)
        {
            $token = $request->cookie('user_token');
            if ($token) {
                $user = User::where('token', $token)->first();
                if ($user && $user->token_expired_at > now()) {
                    // Token valid
                    return response()->json(['message' => 'Token valid', 'user' => $user]);
                }
            }

            return response()->json(['message' => 'Invalid or expired token'], 401);
        }

}
