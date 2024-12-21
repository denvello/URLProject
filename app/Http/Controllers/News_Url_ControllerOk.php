<?php

namespace App\Http\Controllers;

//use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Str;
//use App\Models\NewsUrl;
use App\Models\CommentReply;
use App\Models\Newsurlmodel;
use Illuminate\Http\Request;
use App\Models\Commentsmodel;
use App\Helpers\HtmlSanitizer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class News_Url_Controller extends Controller
{
    public function home() {
        //return view('news_url');
        // mengambil data dari table pegawai
    	$newsurl = DB::table('news_url')->get();
    	// mengirim data pegawai ke view index	
        return view('home',['news_url' => $newsurl]);
    }

    public function find(Request $request)
	{
            $find = $request->find; 
            if (is_null($find) || trim($find) === '') {
                return redirect()->back()->withErrors(['find' => 'Input tidak boleh kosong nih!']);
                //return view('add_news_url')->with('message', 'Input tidak boleh kosong!');
            } else {
                $find = DB::table('news_url')
                ->where('url','like',"%".$find."%")
                ->paginate(20);        
                    return view('home',['news_url' => $find])->with('message', 'Hasil pencarian!');
            }
	}
    public function add()
    {
        // memanggil view tambah
        return view('add_news_url');
    }

    // method untuk insert data ke table news_url
    public function store(Request $request)
    {
        // insert data ke table pegawai
        DB::table('news_url')->insert([
            'url' => $request->url,
            'title' => $request->title,
            
        ]);
        return redirect('/home');
    
    }

    Public function newscommentsjoin () {
        // mengambil semua data news_url
    	$news_urljoin = Newsurlmodel::all();
    	// return data ke view
    	return view('newsurlcomments', ['newsurljoin' => $news_urljoin]);
    }

    Public function cari (Request $request) {
        $find = $request->find;
        if (!is_null($find) && trim($find) !== '') {
           
            $news = Newsurlmodel::where('url', 'like', "%" . $find . "%")
                ->with(['comments_join','user']) // Muat relasi dengan komentar & user
                ->get();
            //return view('newsurlcomments', ['newsurljoin' => $news]);
            return view('newsurlcomments', ['newsurljoin' => $news]);
        } else {
            
            //return view('cari', ['news_url' => [], 'find' => '']);
            return view('newsurlcomments', ['newsurljoin' => $news]);
        }
    }

    Public function cari_old (Request $request) {
        $find = $request->find;
        if (!is_null($find) && trim($find) !== '') {
            $news = DB::table('news_url')
                ->where('url', 'like', "%" . $find . "%")
                ->paginate(20);
            return view('cari', ['news_url' => $news, 'find' => $find])->with('message', 'Hasil pencarian!');
        } else {
            return view('cari', ['news_url' => [], 'find' => '']);
        }
    }


    public function index() {
        //Carbon::setLocale('id');

        //return view('news_url');
        // mengambil data dari table pegawai
    	//$index = DB::table('news_url')->orderBy('created_at', 'desc')->get();
    	$index = DB::table('news_url')->orderBy('created_at', 'desc')->paginate(10);
        // Looping untuk memformat tanggal di setiap item
        //foreach ($index as $item) {
        //$item->formatted_date = Carbon::parse($item->created_at)->format('l, d M Y H:i');
        //$item->formatted_date = Carbon::parse($item->created_at)->translatedFormat('l, d - F - Y H:i:s');
    
        // mengirim data pegawai ke view index	
        return view('carihomeindex',['home_index' => $index]);
    }

    public function addnewurl()
    {
        // memanggil view tambah new url
        return view('addnewurl');
    }

    // method untuk insert data baru ke table news_url
    public function simpannewurl(Request $request)
    {  
        DB::table('news_url')->insert([
            'url' => $request->url,
            'title' => $request->title,   
        ]);
        return redirect('/home/cari');
    }




    // Menampilkan halaman form pencarian LIKE GOOGLE
    public function show(Request $request)
    {
        
        $keyword = $request->input('keyword');
        $keyword = urldecode($keyword);
        //dump($keyword);
        $ipAddress = request()->ip();
        $userAgent = request()->header('User-Agent');
        dump($ipAddress, $userAgent);
    // Ambil keyword dari session
    if (empty($keyword)) {
        $keyword = session('search_keyword', '');
        // dump($keyword);
    } 
    // Kosongkan session ID sebelum memulai pencarian
    session()->forget('news_url_id');
    $find = session('find', '');
    
    session(['search_keyword' => $keyword]); //ini fungsi untuk mengisi keyword dari klik index view di show
    if (!empty($keyword)) {
            // Jika keyword ada, jalankan pencarian
            $news = Newsurlmodel::where('url', 'like', '%' . $keyword . '%')
                //->orWhere('url', 'like', '%' . $find . '%')
            ->orWhere('title', 'like', '%' . $keyword . '%')
            ->with(['comments_join' => function($query) {
                $query->orderBy('created_at', 'desc');
             }, 'user']) 
            ->get();
            
            // Jika hasil pencarian kosong, kosongkan session ID
            if ($news->isEmpty()) {
                session()->forget('news_url_id'); // Menghapus session news_url_id
            } else {
                // Jika ada hasil, simpan ID dari hasil pertama ke session
                session(['news_url_id' => $news[0]->id]);
            }
            // Return view dengan hasil pencarian
            return view('search', [
                'newsurljoin' => $news,
                'find' => $keyword,
        ]);
    }

    if (!empty($find)) {
        // Jika find ada, jalankan pencarian
        $news = Newsurlmodel::where('url', 'like', '%' . $find . '%')
        ->orWhere('title', 'like', '%' . $find . '%')
        ->with(['comments_join' => function($query) {
            $query->orderBy('created_at', 'desc');
         }, 'user']) 
        ->get();
        
        // Jika hasil pencarian kosong, kosongkan session ID
        if ($news->isEmpty()) {
            session()->forget('news_url_id'); // Menghapus session news_url_id
        } else {
            // Jika ada hasil, simpan ID dari hasil pertama ke session
            session(['news_url_id' => $news[0]->id]);
        }


        // Return view dengan hasil pencarian
        return view('search', [
            'newsurljoin' => $news,
            'find' => $keyword,
    ]);
}

        // Jika tidak ada keyword, tampilkan halaman pencarian kosong
        return view('search')->with('message', 'Session tidak ditemukan atau kosong.');
        //return view('search');
    }

   public function search(Request $request)
   {
    $request->validate([
        'find' => 'required|string|max:500',
     ]);

         // Ambil parameter 'url' dari request jika ada
         //$urlParam = $request->input('keyword');
        //  dd($urlParam);
        

        // if ($urlParam) {
        //     $find = $urlParam; // Gunakan nilai URL yang dikirim
        //     session(['search_keyword' => $find]); // Simpan ke session
        // } 
        // else {
            $find = $request->input('find'); // Ambil input dari pengguna
            session(['search_keyword' => $find]);
            $keyword = $request->input('keyword');
            session()->forget('news_url_id');
        // }
        // dd($request->all());


        // $request->validate([
        //     'find' => 'required|string|max:500',
        //  ]);
   
        //    $find = $request->input('find');
        //    $keyword = $request->input('keyword');
        //    session(['search_keyword' => $find]); // Set session dari inputan user 
        //    session()->forget('news_url_id');
        
   
            // Mencari URL yang sesuai dengan input pengguna
       $news = Newsurlmodel::where('url', 'like', '%' . $find . '%')
               ->orWhere('title', 'like', '%' . $find . '%')
               ->with(['comments_join' => function($query) {
                $query->orderBy('created_at', 'desc'); // Urutkan komentar
                }, 'user']) // Muat relasi
               ->get();
               //dd($news); // Untuk melihat data yang dikembalikan
               if ($news->count() > 0) {
                    session(['news_url_id' => $news[0]->id]); // Simpan ID ke session
                    // Mengembalikan ke halaman dengan hasil pencarian dan input tetap di form
                    return view('search', [
                    'newsurljoin' => $news,
                    'find' => $find,
                    ]);
               } else {
                     // Jika tidak ada hasil, jalankan `fetchMetadata` dan kirim hasilnya ke view
                    $metadata = $this->fetchMetadata($find);
                    session(['metadata' => $metadata]); // Simpan ke session untuk akses berikutnya metode dalam array
                    // Simpan judul & deskripsi metadata ke dalam session
                    session(['metadata_title' => $metadata['title'] ?? 'judul tidak tersedia']);
                    session(['metadata_description' => $metadata['description'] ?? 'Deskripsi tidak tersedia']);
                    // Simpan gambar metadata ke dalam session
                    session(['metadata_image' => $metadata['image'] ?? '']);

                    // Tampilkan metadata bersama hasil pencarian kosong di view search
                    return view('search', [
                        'newsurljoin' => [], // Tidak ada hasil pencarian
                        'find' => $find,
                        'metadata' => $metadata, // Hasil metadata
                    ]);

               }
                
   }

    public function searchurlbaru(Request $request)
    {
    //     $request->validate([
    //         'find' => 'required|string|max:255',
    //     ]);
 
        //  $find = $request->input('find');
        //  $keyword = $request->input('keyword');
        //  session(['search_keyword' => $find]); // Set session dari inputan user 
        //  // Kosongkan session ID sebelum memulai pencarian
        //  session()->forget('news_url_id');
        //      // Mencari URL yang sesuai dengan input pengguna
        $find = session('search_keyword', '');

        $news = Newsurlmodel::where('url', 'like', '%' . $find . '%')
                //->orWhere('title', 'like', '%' . $title . '%')
                ->with(['comments_join' => function($query) {
                 $query->orderBy('created_at', 'desc'); // Urutkan komentar
                 }, 'user']) // Muat relasi
                ->get();
                dd($news); // Untuk melihat data yang dikembalikan
                if ($news->count() > 0) {
                     session(['news_url_id' => $news[0]->id]); // Simpan ID ke session
                }
             // Mengembalikan ke halaman dengan hasil pencarian dan input tetap di form
            return view('search', [
                'newsurljoin' => $news,
                'find' => $find,
            ]);
    }
 
   //public function addcomment($id)
   public function addcomment()
   {
       // memanggil view tambah comment
       //return view('addcomment', compact('id'));

       // Set id ke dalam session
        //session(['comment_id' => $id]);
        //$id = session('news_url_id');
        //session(['news_url_id' => $newsurljoin[0]->id]);
        
        // $find = $request->input('find');
        // $keyword = $request->input('keyword');
        // session(['search_keyword' => $find]); // Set session dari inputan user 
        // // Kosongkan session ID sebelum memulai pencarian
        // session()->forget('news_url_id');
        // // Tampilkan view tanpa parameter id di URL
        return view('addcomment');
   }

    // method untuk insert / tambah data komen baru ke table komen
    public function simpankomenbaruold(Request $request)
    {  
        $request->validate([
            // 'comment_text' => 'required|string|max:500|url|unique:news_url,url', // Cek URL unik di kolom 'url' tabel 'news_url'
            'comment_text' => 'required|string|max:500', // Memvalidasi input 'title'
            'imagekomen' => 'required|image|mimes:jpeg,png,jpg,gif|max:100', // Maksimal 100 KB
        ], [
            'comment_text.required' => 'Kolom komen harus diisi max 500 kata.',
            'imagekomen.max' => 'Gambar tidak boleh lebih dari 100KB.',
            'imagekomen.image' => 'File yang diunggah harus berupa gambar.',
            'imagekomen.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.'
        ]);
        $localImagePath = null;
        
        if ($request->hasFile('imagekomen')) {
            $uploadedImage = $request->file('imagekomen');
            // Buat nama file gambar
            $imageName = Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();
            // Simpan gambar di folder public/image tanpa menambahkan 'image/' dua kali
            Storage::disk('public')->putFileAs('imagekomen', $uploadedImage, $imageName);
            // Simpan path yang benar untuk disimpan di database
            $localImagePath = 'imagekomen/' . $imageName; // Folder dan nama file yang benar
        }


        // Tangkap nilai ID dari input hidden
        $id = $request->input('id');
        $searchKeyword = $request->input('search_keyword');
        //$find = $request->input('find');
        // session(['search_keyword' => $find]); // Set session dari inputan user 
        if (!empty($id)) {
        DB::table('comments')->insert([
            'user_id' => rand(1, 50), // sementara masih tembak langsung
            'url_id' => $id, // sementara masih tembak langsung url idnya
            'comment_text' => $request->comment_text,
            'image_comment' => $localImagePath ? asset('storage/' . $localImagePath) : null,  
            // 'created_at' => now(),
            // 'updated_at' => now(), 
        ]);
        }
        return redirect()->route('cari')->with('success', 'Komen baru berhasil disimpan.');
    }


     // method untuk insert / tambah data komen baru ke table komen
     public function simpankomenbaru(Request $request)
     {  
         // Validasi input komentar dengan maksimal 500 kata dan gambar opsional
        $request->validate([
            'comment_text' => ['nullable', function ($attribute, $value, $fail) {
                $maxWords = 500;
                if ($value) {
                    $wordCount = str_word_count($value);
                    if ($wordCount > $maxWords) {
                        $fail("The $attribute field must not be greater than $maxWords words.");
                    }
                }                
            }],
            'imagekomen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:100', // Validasi gambar opsional
        ], [
            'comment_text.required' => 'Kolom komen harus diisi max 500 kata.',
            'imagekomen.image' => 'File yang diunggah harus berupa gambar.',
            'imagekomen.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'imagekomen.max' => 'Ukuran gambar tidak boleh lebih dari 100kb.',
        ]);
        // Menyimpan nilai komentar ke session agar tetap ada meskipun error
         session()->flash('input_comment', $request->comment_text);

        // Proses penyimpanan gambar jika ada
        $localImagePath = null;
        if ($request->hasFile('imagekomen')) {
            $uploadedImage = $request->file('imagekomen');
            $imageName = Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('imagekomen', $uploadedImage, $imageName);
            $localImagePath = 'imagekomen/' . $imageName;
        }

 
         // Tangkap nilai ID dari input hidden
         $id = $request->input('id');
         $searchKeyword = $request->input('search_keyword');
         if (!empty($id)) {
         DB::table('comments')->insert([
             'user_id' => rand(1, 50), // sementara masih tembak langsung
             'url_id' => $id, // sementara masih tembak langsung url idnya
             'comment_text' => $request->comment_text,
             'image_comment' => $localImagePath ? asset('storage/' . $localImagePath) : null,  
         ]);
         }
         return redirect()->route('cari')->with('success', 'Komen baru berhasil disimpan.');

     }
    public function addnewurlbaru()
    {
        // memanggil view tambah new url
        // Kosongkan session ID sebelum memulai pencarian
        //$find = session('find', '');
        
        
        $keyword = session('search_keyword', '');
       
        // session()->forget('search_keyword'); kenapa harus di kosongkan ya? 
        return view('addnewurlbaru');
    }

    public function simpannewurlbaru(Request $request)
    {   
        // Validasi input URL dan title
        $request->validate([
            'find' => 'required|string|max:500|url|unique:news_url,url', // Cek URL unik di kolom 'url' tabel 'news_url'
            'title' => 'required|string|max:500', // Memvalidasi input 'title'
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // Maksimal 1 MB
        ], [
            'find.unique' => 'Alamat URL sudah ada di database.', // Pesan error kustom untuk URL duplikat
            'find.required' => 'Kolom URL harus diisi.',
            'title.required' => 'Kolom judul harus diisi.',
            'image.max' => 'Gambar tidak boleh lebih dari 1MB.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',    
        ]);

       // Ambil metadata dari session yang sudah disimpan di view search
        $metadata = session('metadata');
        $imageUrl = session('metadata_image') ?? null;
        $localImagePath = null;

        // Jika ada URL gambar, unduh dan simpan di folder `public/img/`
       
        // if ($imageUrl) {
        //     $imageContents = Http::get($imageUrl)->body(); // Ambil konten gambar
        //     $imageName = 'image/' . Str::random(20) . '.jpg'; // Nama file unik untuk disimpan

        //     // Simpan gambar di folder public/img
        //     Storage::disk('public')->put($imageName, $imageContents);
        //     $localImagePath = $imageName; // Simpan path gambar untuk database
        // } 


        // else {
        //     // Jika tidak ada gambar metadata, perbolehkan pengguna mengunggah gambar
        //     $request->validate([
        //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:100', // Maksimal 100 KB
        //     ], [
        //         'image.max' => 'Gambar tidak boleh lebih dari 100KB.',
        //         'image.image' => 'File yang diunggah harus berupa gambar.',
        //         'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.'
        //     ]);

        //     if ($request->hasFile('image')) {
        //         $uploadedImage = $request->file('image');
        //         // Buat nama file gambar
        //         $imageName = Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();
        //         // Simpan gambar di folder public/image tanpa menambahkan 'image/' dua kali
        //         Storage::disk('public')->putFileAs('image', $uploadedImage, $imageName);
        //         // Simpan path yang benar untuk disimpan di database
        //         $localImagePath = 'image/' . $imageName;
        //     }
        // }

        if ($request->hasFile('image')) {
            $uploadedImage = $request->file('image');
            $imageName = Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('image', $uploadedImage, $imageName);
            $localImagePath = 'image/' . $imageName;
        } elseif ($imageUrl) {
            $imageContents = Http::get($imageUrl)->body();
            $imageName = 'image/' . Str::random(20) . '.jpg';
            Storage::disk('public')->put($imageName, $imageContents);
            $localImagePath = $imageName;
        }

        DB::table('news_url')->insert([
            'url' => $request->find,
            'title' => $request->title,
            'desc' => $request->description ?? $metadata['description'], // Prioritaskan input user
            'news_user_id' => rand(1, 60), // sementara masih tembak langsung
            // 'image_url' => $metadata['image'] ?? null, // Simpan URL gambar metadata
            'image_url' => $localImagePath ? asset('storage/' . $localImagePath) : null,
        ]);
        
        $find = $request->input('find');
        $searchKeyword = $request->input('title');
        session(['search_keyword' => $find]); // Simpan nilai find ke session jika diperlukan
       return redirect()->route('cari')->with('success', 'Data URL baru berhasil disimpan.');

    }

    public function simpannewurlbaruok(Request $request)
    {   
        // Validasi input URL dan title
        $request->validate([
            'find' => 'required|string|max:500|url|unique:news_url,url', // Cek URL unik di kolom 'url' tabel 'news_url'
            'title' => 'required|string|max:500', // Memvalidasi input 'title'
        ], [
            'find.unique' => 'Alamat URL sudah ada di database.', // Pesan error kustom untuk URL duplikat
            'find.required' => 'Kolom URL harus diisi.',
            'title.required' => 'Kolom judul harus diisi.'
           
        ]);
        // Ambil metadata dari URL (misalnya menggunakan method fetchMetadata)
        //$metadata = $this->fetchMetadata($request->find);
        //$imageUrl = $metadata['image'] ?? null;
        
        // Ambil metadata dari session yang sudah disimpan di view search
        $metadata = session('metadata');
        $imageUrl = session('metadata_image') ?? null;
        // Jika ada URL gambar, unduh dan simpan di folder `public/img/`
        $localImagePath = null;
        if ($imageUrl) {
            $imageContents = Http::get($imageUrl)->body(); // Ambil konten gambar
            $imageName = 'image/' . Str::random(20) . '.jpg'; // Nama file unik untuk disimpan

            // Simpan gambar di folder public/img
            Storage::disk('public')->put($imageName, $imageContents);
            $localImagePath = $imageName; // Simpan path gambar untuk database
        } else {
            // Jika tidak ada gambar metadata, perbolehkan pengguna mengunggah gambar
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:100', // Maksimal 100 KB
            ], [
                'image.max' => 'Gambar tidak boleh lebih dari 100KB.',
                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.'
            ]);

            if ($request->hasFile('image')) {
                $uploadedImage = $request->file('image');
                // Buat nama file gambar
                $imageName = Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();
                // Simpan gambar di folder public/image tanpa menambahkan 'image/' dua kali
                Storage::disk('public')->putFileAs('image', $uploadedImage, $imageName);
                // Simpan path yang benar untuk disimpan di database
                $localImagePath = 'image/' . $imageName;
            }
        }

        DB::table('news_url')->insert([
            'url' => $request->find,
            'title' => $request->title,
            'desc' => $request->description ?? $metadata['description'], // Prioritaskan input user
            'news_user_id' => rand(1, 60), // sementara masih tembak langsung
            // 'image_url' => $metadata['image'] ?? null, // Simpan URL gambar metadata
            'image_url' => $localImagePath ? asset('storage/' . $localImagePath) : null,
        ]);
        
        // // $find = $request->url;
        $find = $request->input('find');
        $searchKeyword = $request->input('title');
        session(['search_keyword' => $find]); // Simpan nilai find ke session jika diperlukan
        //session()->forget('metadata'); // Hapus metadata dari session
        //return redirect()->route('cari'); // ini asli yg jalan
        return redirect()->route('cari')->with('success', 'Data URL baru berhasil disimpan.');

    }

    public function simpannewurlbaruold(Request $request) //yg asli sudah jalan
    {   
        // Validasi input URL dan title
        $request->validate([
            'find' => 'required|string|max:500|url|unique:news_url,url', // Cek URL unik di kolom 'url' tabel 'news_url'
            'title' => 'required|string|max:500', // Memvalidasi input 'title'
        ], [
            'find.unique' => 'Alamat URL sudah ada di database.', // Pesan error kustom untuk URL duplikat
            'find.required' => 'Kolom URL harus diisi.',
            'title.required' => 'Kolom judul harus diisi.'
           
        ]);
        // Ambil metadata dari URL (misalnya menggunakan method fetchMetadata)
        $metadata = $this->fetchMetadata($request->find);
        $imageUrl = $metadata['image'] ?? null;
        // Jika ada URL gambar, unduh dan simpan di folder `public/img/`
        $localImagePath = null;
        if ($imageUrl) {
            $imageContents = Http::get($imageUrl)->body(); // Ambil konten gambar
            $imageName = 'image/' . Str::random(20) . '.jpg'; // Nama file unik untuk disimpan

            // Simpan gambar di folder public/img
            Storage::disk('public')->put($imageName, $imageContents);
            $localImagePath = $imageName; // Simpan path gambar untuk database
        } else {
            // Jika tidak ada gambar metadata, perbolehkan pengguna mengunggah gambar
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:100', // Maksimal 100 KB
            ], [
                'image.max' => 'Gambar tidak boleh lebih dari 100KB.',
                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.'
            ]);

            if ($request->hasFile('image')) {
                // $uploadedImage = $request->file('image');
                // $imageName = 'image/' . Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();
                // Storage::disk('public')->putFileAs('image', $uploadedImage, $imageName);
                // $localImagePath = $imageName;
                
                $uploadedImage = $request->file('image');
                // Buat nama file gambar
                $imageName = Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();
                // Simpan gambar di folder public/image tanpa menambahkan 'image/' dua kali
                Storage::disk('public')->putFileAs('image', $uploadedImage, $imageName);
                // Simpan path yang benar untuk disimpan di database
                $localImagePath = 'image/' . $imageName;
            }
        }

        DB::table('news_url')->insert([
            'url' => $request->find,
            'title' => $request->title,
            'desc' => $request->description ?? $metadata['description'], // Prioritaskan input user
            'news_user_id' => rand(1, 60), // sementara masih tembak langsung
            // 'image_url' => $metadata['image'] ?? null, // Simpan URL gambar metadata
            'image_url' => $localImagePath ? asset('storage/' . $localImagePath) : null,
        ]);
        
        // // $find = $request->url;
        $find = $request->input('find');
        $searchKeyword = $request->input('title');
        session(['search_keyword' => $find]); // Simpan nilai find ke session jika diperlukan

        //return redirect()->route('cari'); // ini asli yg jalan
        return redirect()->route('cari')->with('success', 'Data URL baru berhasil disimpan.');

    }


   

    public function searchById($id)
    {
        //$news = Newsurlmodel::where('title', $id)->with(['comments_join', 'user'])->get();
        $news = Newsurlmodel::where('title', $id)
        ->with(['comments_join' => function($query) {
            $query->orderBy('created_at', 'desc'); // atau 'desc' untuk urutan sebaliknya
        }, 'user'])
        ->get();

        session(['search_keyword' => $id]); // Set session dari inputan user
    
        session(['news_url_id' => $news[0]->id]); 
    
    // session()->forget('news_url_id');
   
    if ($news->isNotEmpty()) {
        // session(['search_keyword' =>$news->first()->title]); // Optional: store title or ID in session if needed
        return view('searchbyid', [
            'newsurljoin' => $news, // Pass as a collection
            // 'find' => $news->title,
        ]);
    } else {
        return redirect()->route('cari')->with('message', 'Data not found');
    }
    }


    public function searchById2($id)
    {
    $news = Newsurlmodel::where('id', $id)->with(['comments_join', 'user'])->get();
    // dd($news);
    if ($news->isNotEmpty()) {
        // session(['search_keyword' =>$news->first()->title]); // Optional: store title or ID in session if needed
        return view('searchbyid', [
            'newsurljoin' => $news, // Pass as a collection
            // 'find' => $news->title,
        ]);
    } else {
        return redirect()->route('cari')->with('message', 'Data not found');
    }
    }

    

public function fetchMetadata($url)
{
    try {
    // Make a GET request to the URL
    $response = Http::get($url);

        if ($response->successful()) {
            // Load HTML into DOMDocument
            $html = new \DOMDocument();
            @$html->loadHTML($response->body());

            // Use DOMXPath to extract specific metadata
            $xpath = new \DOMXPath($html);

            // Extract title, image, and description
            $title = $xpath->query("//meta[@property='og:title']")->item(0)?->getAttribute('content') ??
                    $xpath->query("//title")->item(0)?->nodeValue;

            $image = $xpath->query("//meta[@property='og:image']")->item(0)?->getAttribute('content');

            $description = $xpath->query("//meta[@property='og:description']")->item(0)?->getAttribute('content') ??
                        $xpath->query("//meta[@name='description']")->item(0)?->getAttribute('content');

            $author = $xpath->query("//meta[@name='author']")->item(0)?->getAttribute('content');

             $publishDate = $xpath->query("//meta[@property='article:published_time']")->item(0)?->getAttribute('content') ??
                       $xpath->query("//meta[@name='publish_date']")->item(0)?->getAttribute('content');

            
                        return [
                            'title' => $title,
                            'image' => $image,
                            'description' => $description,
                            'author' => $author ?? 'Author not available',
                            'publish_date' => $publishDate ?? 'Publish date not available',
                
            ];
        } else {
            return ['error' => 'Could not retrieve metadata'];
        }
    } catch (\Exception $e) {
        return ['error' => 'Error: ' . $e->getMessage()];
    }
}

public function showMetadataold($url)
{
    $metadata = $this->fetchMetadata($url);

    return view('metadata', compact('metadata'));
}

public function showMetadata(Request $request)
{
    $request->validate([
        'url' => 'required|url', // Validate that URL is properly formatted
    ]);
    $url = $request->input('url');
    $metadata = $this->fetchMetadata($url); // Call fetchMetadata function
    return view('metadata', compact('metadata'));
}



public function showForm()
{
    // Show the form to input URL
    return view('input_url_form');
}


public function storeReply(Request $request, $commentId)
{
    $request->validate([
        'reply_text' => 'required|string|max:500',
    ]);

    CommentReply::create([
        'comment_id' => $commentId,
        'user_id' => auth()->id(), // Asumsi user sudah login
        'reply_text' => $request->input('reply_text'),
    ]);

    // return redirect()->back()->with('success', 'Balasan berhasil ditambahkan.');
    return redirect()->route('cari')->with('success', 'Balasan berhasil ditambahkan.');
}

public function showCommentsWithReplies($newsId)
{
    // Fetch the news URL and its related comments along with their replies
    $newsurl = Newsurlmodel::with(['comments_join.commentReplies', 'comments_join.user'])
        ->findOrFail($newsId);
    
    return view('comments.index', compact('newsurl'));
}

public function saveCommentReply(Request $request, $commentId)
{
    // Validate the reply text
    $request->validate([
        'reply_text' => 'required|string|max:1000', // Adjust max length as needed
        'reply_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:100',
        ], [
            'reply_image.max' => 'File gambar yang diunggah tidak boleh lebih dari 100KB.', // Custom message for max size
        ]);
    

    // Proses penyimpanan file gambar jika ada
    $imagePath = null;
    if ($request->hasFile('reply_image')) {
        // $imagePath = $request->file('reply_image')->store('reply_images', 'public'); // Simpan di storage public/reply_images
        
        // Simpan file gambar di folder storage dan dapatkan pathnya
        $storedPath = $request->file('reply_image')->store('reply_images', 'public');
        $imagePath = asset('storage/' . $storedPath);
       

        // $uploadedImage = $request->file('reply_image');
        // $imageName = Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();
        // Storage::disk('public')->putFileAs('reply_image', $uploadedImage, $imageName);
        // $localImagePath = 'reply_image/' . $imageName;
    }

    DB::table('comment_replies')->insert([
        'comment_id' => $commentId,
        'user_id' => rand(1, 50), // Assuming user is authenticated
        'reply_text' => $request->input('reply_text'),
        // 'created_at' => now(),  // Manual timestamp
        // 'updated_at' => now(),  // Manual timestamp
        'image_reply' => $imagePath, // Menyimpan path gambar jika ada
        //'image_reply' => localImagePath, // Menyimpan path gambar jika ada
        //dd()
      
    ]);
    // Redirect back to the same page with a success message
    return back()->with('success', 'Reply posted successfully!');
}

    public function addnewproduct()
    {
        // memanggil view tambah new url
        return view('addnewproductbaru');
    }

    public function simpannewproduct(Request $request)
    {   
        // Validasi input URL dan title
        $request->validate([
            'find' => 'required|string|max:500|url|unique:news_url,url', // Cek URL unik di kolom 'url' tabel 'news_url'
            'title' => 'required|string|max:500', // Memvalidasi input 'title'
        ], [
            'find.unique' => 'Alamat URL sudah ada di database.', // Pesan error kustom untuk URL duplikat
            'find.required' => 'Kolom URL harus diisi.',
            'title.required' => 'Kolom judul harus diisi.'
           
        ]);
        // Ambil metadata dari URL (misalnya menggunakan method fetchMetadata)
        //$metadata = $this->fetchMetadata($request->find);
        //$imageUrl = $metadata['image'] ?? null;
        
        // Ambil metadata dari session yang sudah disimpan di view search
        $metadata = session('metadata');
        $imageUrl = session('metadata_image') ?? null;
        // Jika ada URL gambar, unduh dan simpan di folder `public/img/`
        $localImagePath = null;
        if ($imageUrl) {
            $imageContents = Http::get($imageUrl)->body(); // Ambil konten gambar
            $imageName = 'image/' . Str::random(20) . '.jpg'; // Nama file unik untuk disimpan

            // Simpan gambar di folder public/img
            Storage::disk('public')->put($imageName, $imageContents);
            $localImagePath = $imageName; // Simpan path gambar untuk database
        } else {
            // Jika tidak ada gambar metadata, perbolehkan pengguna mengunggah gambar
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:100', // Maksimal 100 KB
            ], [
                'image.max' => 'Gambar tidak boleh lebih dari 100KB.',
                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.'
            ]);

            if ($request->hasFile('image')) {
                $uploadedImage = $request->file('image');
                // Buat nama file gambar
                $imageName = Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();
                // Simpan gambar di folder public/image tanpa menambahkan 'image/' dua kali
                Storage::disk('public')->putFileAs('image', $uploadedImage, $imageName);
                // Simpan path yang benar untuk disimpan di database
                $localImagePath = 'image/' . $imageName;
            }
        }

        DB::table('news_url')->insert([
            'url' => $request->find,
            'title' => $request->title,
            'desc' => $request->description ?? $metadata['description'], // Prioritaskan input user
            'news_user_id' => rand(1, 60), // sementara masih tembak langsung
            // 'image_url' => $metadata['image'] ?? null, // Simpan URL gambar metadata
            'image_url' => $localImagePath ? asset('storage/' . $localImagePath) : null,
        ]);
        
        // // $find = $request->url;
        $find = $request->input('find');
        $searchKeyword = $request->input('title');
        session(['search_keyword' => $find]); // Simpan nilai find ke session jika diperlukan
        //session()->forget('metadata'); // Hapus metadata dari session
        //return redirect()->route('cari'); // ini asli yg jalan
        return redirect()->route('cari')->with('success', 'Data URL baru berhasil disimpan.');

    }

    public function createproduct()
    {
        return view('product.create');
    }

    public function storeproduct(Request $request)
    {
        //dd($request->all());
        // Validasi form
        $validator = Validator::make($request->all(), [
            //$request->validate([
            //'product_user_id' => rand(1, 50),
            'product_name' => 'required|max:255',
            // 'product_description' => 'nullable',
            'product_description' => 'nullable|string', // HTML editor disimpan sebagai string
            'product_price' => 'required|numeric',
            // 'product_contact_number' => 'required|numeric',
            //'product_contact_number' => 'required|string|regex:/^(\+62|62|0)[0-9]{9,15}$/',
            'product_contact_number' => ['required', 'string','regex:/(\+62|62|0)8[1-9][0-9]{6,9}$/'],
            // 'url' => 'required|url|unique:products,url',
            'product_images' => 'required|array|max:5',
            'product_images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
       
         // Bersihkan HTML berbahaya dari judul dan deskripsi
        $cleanTitle = HtmlSanitizer::sanitize($request->input('product_name'));
        $cleanDescription = HtmlSanitizer::sanitize($request->input('product_description'));


        // Periksa apakah masih ada tag berbahaya
        if (preg_match('/<script|<iframe|<object|onload=|onerror=/', $cleanTitle) || preg_match('/<script|<iframe|<object|onload=|onerror=/', $cleanDescription)) {
            return redirect()->back()->with('error', 'Judul atau deskripsi mengandung elemen HTML berbahaya!');
        }

        // Simpan produk baru
        $product = new Product();
        $product->product_user_id = rand(1, 50);
        $product->product_name = $cleanTitle;
        // $product->product_description = $request->input('product_description');
        $product->product_description = $cleanDescription;
        $product->product_price = $request->input('product_price');
        $product->product_contact_number = $request->input('product_contact_number');
        //$product->url = $request->input('url');
        $product->save();
            if ($request->hasFile('product_images')) {
                $files = $request->file('product_images');
                //dd($files);
                foreach ($files as $key => $file) {
                    if ($key < 5) {
                        $path = $file->store('imagesproduct', 'public');
                        $product->{"product_image" . ($key + 1) . "_url"} = $path;
                    }
                }
                $product->save();
            }
            
            
        // Redirect ke halaman produk setelah disimpan, dan menampilkan pesan sukses
        // return redirect()->route('product.show', $product->id)
        //                  ->with('success', 'Produk berhasil disimpan!');
        
        return redirect()->route('product.show',  ['id' => $product->id, 'product_name' => Str::slug($product->product_name)])
                         ->with('success', 'Produk berhasil disimpan!');

    }

    public function showproduct($id, $product_name)
    {
        // $product = Product::findOrFail($id);
        // //return view('showproduct', compact('product'));
        // $product = Product::where('id', $id)
        //               ->where('product_name', $product_name)
        //               ->firstOrFail();

        // Mencari produk berdasarkan ID dan product_name (dalam format slug)
        // Mengubah 'product_name' dari URL menjadi format yang sesuai untuk pencarian
        $formattedProductName = str_replace('-', ' ', $product_name);

        $product = Product::where('id', $id)
                    ->where('product_name', $formattedProductName)
                    ->firstOrFail();
        
        return view('showproduct', compact('product'));            

    }

    // public function saveProductUrl(Request $request, $id)
    // {
    //     $request->validate([
    //         'url' => 'required|url|max:255',
    //     ]);

    //     $product = Product::findOrFail($id);
    //     $product->url = $request->input('url');
    //     dd($id);
    //     $product->save();

    //     return response()->json(['message' => 'URL produk berhasil disimpan.']);
    // }

    public function saveProductUrl(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'url' => 'required|url|max:255',
            ]);

            // Temukan produk berdasarkan ID
            $product = Product::findOrFail($id);

            // Simpan URL ke field 'url'
            $product->url = $request->input('url');
            $product->save();

            // Kembalikan respon JSON sukses
            return response()->json(['message' => 'URL produk berhasil disimpan.']);
        } catch (\Exception $e) {
            // Tangani error dengan respon JSON
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan URL.', 'error' => $e->getMessage()], 500);
        }
    }

}