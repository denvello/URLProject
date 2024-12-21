<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function showEnterPasswordForm()
    {
        return view('enter_password');
    }

    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $token = Cookie::get('user_token');
        dump($token);
        // $user = User::where('token', $token)->first();
        $user = User::where('remember_token', $token)->first();
        dd($user);


        if (Hash::check($request->password, $user->password)) {
            echo "Password cocok";
        } else {
            echo " Password tidak cocok";
        }
        
        if ($user && Hash::check($request->password, $user->password)) {
            // Password cocok, lanjutkan aplikasi
            return redirect()->route('search'); // Ganti dengan halaman tujuan
        } else {
            // Password tidak cocok atau token tidak valid
            return redirect()->route('enter_password')->withErrors('Password salah atau token tidak valid.');
        }
    }


        public function updatePasswordsToBcrypt()
    {
        // Ambil semua user dari database
        $users = User::all();

        foreach ($users as $user) {
            // Cek apakah password sudah di-hash dengan Bcrypt
            if (!Hash::needsRehash($user->password)) {
                // Jika password belum di-hash dengan Bcrypt, hash ulang dan simpan
                $user->password = Hash::make($user->password);
                $user->save();
            }
        }

        return "Password users telah diperbarui ke format Bcrypt.";
    }


    public function checkToken(Request $request)
    {
        // Ambil token dari cookies
        $token = $request->cookie('user_token');

        if ($token) {
            // Cek apakah token tersebut ada di database
            $user = User::where('token', $token)->first();

            if ($user) {
                // Token valid, lakukan verifikasi password atau lanjutkan
                return view('enter_password', ['user' => $user]);
            } else {
                // Token tidak valid, buat token baru
                return $this->generateNewToken($request);
            }
        } else {
            // Token tidak ditemukan, buat token baru
            return $this->generateNewToken($request);
        }
    }

    private function generateNewToken(Request $request)
    {
        // Generate token baru
        $newToken = hash('sha256', Str::random(60));

        // Simpan token ke database (misalnya dengan user ID)
        User::create([
            'token' => $newToken,
            'password' => bcrypt('default_password'), // atau password awal
        ]);

        // Simpan token ke cookies (misalnya selama 1 tahun)
        return response('Token baru dibuat')->cookie(
            'user_token', $newToken, 525600 // 1 tahun dalam menit
        );
    }
    
    public function usersindex(Request $request)
    {
        $sortBy = $request->input('sort_by', 'created_at'); // Default sorting by created_at
        $sortDirection = $request->input('sort_direction', 'desc'); // Default descending order

        $users = User::orderBy($sortBy, $sortDirection)->paginate(10);

        return view('dashboard.users', compact('users', 'sortBy', 'sortDirection'));
    }

    public function listUsers(Request $request)
    {
        $query = User::query();

        if ($request->has('sort_by') && $request->has('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        }

        $users = $query->paginate(10);

        return view('dashboard.users', compact('users'));
    }

    public function userProfile(Request $request)
    {
        $query = User::query();

        // Jika ada pencarian
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        // Ambil data pengguna untuk profil spesifik
        $users = $query->orderBy('name')->paginate(10);
        
        return view('dashboard.userprofile', compact('users'));
    }


}