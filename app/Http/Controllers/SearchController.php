<?php

namespace App\Http\Controllers;

use App\Models\Newsurlmodel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
   // Menampilkan halaman form pencarian
   public function show()
   {
       return view('search'); // Menggunakan view 'search.blade.php'
   }

   // Memproses hasil pencarian
   public function search(Request $request)
   {
       $request->validate([
           'find' => 'required|string|max:255',
       ]);

       $find = $request->input('find');

       // Mencari URL yang sesuai dengan input pengguna
       $news = Newsurlmodel::where('url', 'like', '%' . $find . '%')
               ->orWhere('title', 'like', '%' . $find . '%')
               ->get();

       // Mengembalikan ke halaman dengan hasil pencarian dan input tetap di form
       return view('search', [
           'news' => $news,
           'find' => $find,
       ]);
   }
}