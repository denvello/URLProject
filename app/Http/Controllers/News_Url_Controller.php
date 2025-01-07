<?php

namespace App\Http\Controllers;

//use Carbon\Carbon;
use App\Models\News;
use App\Models\User;
//use App\Models\NewsUrl;
use App\Models\Vote;
use App\Models\Scans;
use App\Models\Product;
use App\Models\Feedback;
use App\Models\SearchLog;
use Illuminate\Support\Str;
use App\Models\CommentReply;
use App\Models\Newsurlmodel;
// use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Models\Commentsmodel;
use App\Helpers\HtmlSanitizer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Models\NewsUrlSimple;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;





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


    // public function index() {
       
    // 	$index = DB::table('news_url')->orderBy('created_at', 'desc')->paginate(10);
        
    //     // mengirim data pegawai ke view index	
    //     return view('carihomeindex',['home_index' => $index]);
    // }

    public function showindexprod() 
    {
    	$indexprod = DB::table('products')->orderBy('created_at', 'desc')->paginate(15);  
        return view('homeindexprod',['home_index_prod' => $indexprod]);
    }

    public function showindexurl() 
    {
        $newsData = NewsUrlModel::withCount('comments_join')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
             //dd($newsData);
        return view('homeindexurl', compact('newsData'));
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
    public function showdulu(Request $request)
    {
        // $find = $request->input('find');
        // $searchKeyword = $request->input('title');
        // session(['search_keyword' => $cleanUrl]);
       
       
        $keyword = $request->input('keyword');
        $keyword = urldecode($keyword);
        //dump($keyword);
        $ipAddress = request()->ip();
        $userAgent = request()->header('User-Agent');
        //dump($ipAddress, $userAgent);
        // Ambil keyword dari session
         
        //  if (!$request->session()->has('url.intended')) {
        //     $request->session()->put('url.intended', url()->previous());
        //  }
        //     // Redirect ke halaman sebelumnya
        //     return redirect()->intended()->with('success', 'User return back page');


        if (empty($keyword)) {
            $keyword = session('search_keyword', '');
            $keyword = session('url_slug', '');
            //dump($keyword);
        } 
        // Kosongkan session ID sebelum memulai pencarian
        session()->forget('news_url_id');
        $find = session('find', '');
        //dump($find);
        $urlslug = session('urlslug', '');
        session(['search_keyword' => $keyword]); //ini fungsi untuk mengisi keyword dari klik index view di show
            if (!empty($keyword)) {
               
                // Query menggunakan model tanpa relasi
                $news = NewsUrlSimple::where('url', 'like', '%' . $keyword . '%')
                    ->orWhere('title', 'like', '%' . $keyword . '%')
                    ->orderBy('created_at', 'desc')
                    // ->paginate(20)
                    ->get();

                    // Jika hasil pencarian kosong, kosongkan session ID
                if ($news->isEmpty()) {
                    session()->forget('news_url_id'); // Menghapus session news_url_id
                    session()->forget('url_slug'); 
                // } else {
                    // Jika ada hasil, simpan ID dari hasil pertama ke session
                    //session(['news_url_id' => $news[0]->id]);
                }
                // Return view dengan hasil pencarian
                // return view('showdetail', [
                return view('searchdulu', [
                    'newsurljoin' => $news,
                    'find' => $keyword,
                ]);
            }

            // if (!empty($find)) {
                
            //     $news = NewsUrlSimple::where('url', 'like', '%' . $keyword . '%')
            //     ->orWhere('title', 'like', '%' . $keyword . '%')
            //     ->orderBy('created_at', 'desc')
               
            //     ->get();
                
            //     if ($news->isEmpty()) {
            //         session()->forget('news_url_id'); // Menghapus session news_url_id
            //         session()->forget('url_slug'); // Menghapus session news_url_id
                
            //     }

            //     return view('searchdulu', [
            //         'newsurljoin' => $news,
            //         'find' => $keyword,
            //     ]);
            // }

            if (!empty($urlslug)) {
            
                $news = NewsUrlSimple::where('url_slug', '=', $urlslug)
                ->firstOrFail();

                return view('searchdulu', [
                    'newsurljoin' => $news,
                    'find' => $keyword,
                ]);
            }


            // Jika tidak ada keyword, tampilkan halaman pencarian kosong
            return view('searchdulu')->with('message', 'Session tidak ditemukan atau kosong.');
            // return redirect()->route('home')->with('message', 'Session tidak ditemukan atau kosong.');

           
    }

    // public function showdetil($id)  //dari tampilan IG ke detail
    // {
    //     $news = Newsurlmodel::with('comments_join.user', 'user')->findOrFail($id);
    //     return view('search', ['news' => $news]);
    // }

     // Menampilkan halaman form pencarian LIKE GOOGLE
     public function show(Request $request)
     {
         
         $keyword = $request->input('keyword');
         $keyword = urldecode($keyword);
         //dump($keyword);
         $ipAddress = request()->ip();
         $userAgent = request()->header('User-Agent');
         //dump($ipAddress, $userAgent);
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
        $find = $request->input('find'); // Ambil input dari pengguna
        session(['search_keyword' => $find]);
        $keyword = $request->input('keyword');
        session()->forget('news_url_id');
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

   public function searchdulu(Request $request)
   {
    $request->validate([
        'find' => 'required|string|max:500',
     ]);
        $find = $request->input('find'); // Ambil input dari pengguna
        session(['search_keyword' => $find]);
        $keyword = $request->input('keyword');
        session()->forget('news_url_id');
        
        $urlslug = $request->input('url_slug'); // Ambil input dari pengguna
        session(['url_slug' => $urlslug]);

        //$searchType = filter_var($find, FILTER_VALIDATE_URL) ? 'url' : 'word';
        if (filter_var($find, FILTER_VALIDATE_URL)) {
            $searchType = 'url';
        } elseif (is_numeric($find)) {
            $searchType = 'numeric';
        } else {
            $searchType = 'word';
        }
        

    // Simpan pencarian
    SearchLog::updateOrCreate(
        [
            'search_keyword' => $find,
            'search_type' => $searchType,
            'user_id' => auth()->id(), // Relasi ke user yang login
        ],
        [
            'search_count' => \DB::raw('search_count + 1'),
        ]
    );
   
        $newsData = NewsUrlModel::where('url', 'like', '%' . $find . '%')
                ->orWhere('title', 'like', '%' . $find . '%')
                // ->orWhere('desc', 'like', '%' . $find . '%')
                ->withCount('comments_join') // Menghitung jumlah komentar
                ->orderBy('created_at', 'desc')
                ->paginate(15); // Pagination dengan 15 data per halaman  
              
            if ($newsData->count() > 0) {
                    return view('homeindexurl', [
                    'newsData' => $newsData,
                    'find' => $find,
                    ]);
            } else {
                     // Jika tidak ada hasil, jalankan `fetchMetadata` dan kirim hasilnya ke view
                    if ($searchType === 'url') { 
                        $metadata = $this->fetchMetadata($find);
                    } elseif ($searchType === 'numeric' || $searchType === 'word') {    
                        $metadata = "";
                    }       
                        session(['metadata' => $metadata]); // Simpan ke session untuk akses berikutnya metode dalam array
                        // Simpan judul & deskripsi, author metadata ke dalam session
                        session(['metadata_title' => $metadata['title'] ?? '']);
                        session(['metadata_description' => $metadata['description'] ?? '']);
                        session(['metadata_author' => $metadata['author'] ?? '']);
                        // Simpan gambar metadata ke dalam session
                        session(['metadata_image' => $metadata['image'] ?? '']);

                        return view('searchdulu', [
                            'newsData' => [], // Tidak ada hasil pencarian
                            'find' => $find,
                            'metadata' => $metadata, // Hasil metadata
                        ]);
            }
   
   }

   public function searchduluprod(Request $request)
   {
   
        $request->validate([
        'find' => 'required|string|max:500',
     ]);
        $find = $request->input('find'); // Ambil input dari pengguna
        session(['search_keyword' => $find]);
        // $keyword = $request->input('keyword');
        session()->forget('news_url_id');
        
        // $urlslug = $request->input('url_slug'); // Ambil input dari pengguna
        // session(['url_slug' => $urlslug]);

        $cleanFind = HtmlSanitizer::sanitize($request->input('find'));
        
        if (is_string($cleanFind) && preg_match('/^[a-zA-Z0-9\s]+$/', $cleanFind)) {
            // Validasi bahwa string hanya mengandung huruf, angka, dan spasi
            $searchType = 'Product';
        } else {
            $searchType = 'invalid';
        }
        

    // Simpan pencarian
    SearchLog::updateOrCreate(
        [
            'search_keyword' => $cleanFind,
            'search_type' => $searchType,
            'user_id' => auth()->id(), // Relasi ke user yang login
        ],
        [
            'search_count' => \DB::raw('search_count + 1'),
        ]
    );

        $indexprod = Product::where('product_name', 'like', '%' . $cleanFind . '%')
                ->orWhere('product_description', 'like', '%' . $cleanFind . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(15); // Pagination dengan 15 data per halaman  
              
            if ($indexprod->count() > 0) {
                    return view('homeindexprod', [
                    'home_index_prod' => $indexprod,
                    'find' => $cleanFind,
                    ]);
            } else {
                  
                    return view('homeindexprod', [
                        'home_index_prod' => [], // Tidak ada hasil pencarian
                        'find' => $cleanFind,
                        // 'metadata' => $metadata, // Hasil metadata
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
                //dd($news); // Untuk melihat data yang dikembalikan
                if ($news->count() > 0) {
                     session(['news_url_id' => $news[0]->id]); // Simpan ID ke session
                }
             // Mengembalikan ke halaman dengan hasil pencarian dan input tetap di form
            return view('search', [
                'newsurljoin' => $news,
                'find' => $find,
            ]);
    }
 
  
   public function addcomment()
   {
        return view('addcomment');
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
            'imagekomen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500', // Validasi gambar opsional
        ], [
            'comment_text.required' => 'Kolom komen harus diisi max 500 kata.',
            'imagekomen.image' => 'File yang diunggah harus berupa gambar.',
            'imagekomen.mimes' => 'Gambar harus berformat jpeg, png, jpg, webp, atau gif.',
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
         $urlslug = $request->input('url_slug');
         if (!empty($id)) {
         DB::table('comments')->insert([
             'user_id' => auth()->id(), //rand(1, 50), // sementara masih tembak langsung
             'url_id' => $id, 
            //  'url_slug'=> Str::random(30), 
             'comment_text' => $request->comment_text,
             'image_comment' => $localImagePath ? asset('storage/' . $localImagePath) : null,  
         ]);
         }
       
        // return redirect()->route('cari.showdetail', [$id , $searchKeyword])->with('success', 'Komentar berhasil ditambahkan!');
        return redirect()->route('cari.showdetail', [$id , $searchKeyword, $urlslug])->with('success', 'Komentar berhasil ditambahkan!');
     

     }
    public function addnewurlbaru()
    {
        $keyword = session('search_keyword', '');
        return view('addnewurlbaru');
    }

    public function simpannewurlbaru(Request $request)
    {   
        // Validasi input URL dan title (membersihkan lagi)
        $request->merge([
            'title' => preg_replace('/[^a-zA-Z0-9. ]/', ' ', $request->title),
        ]);

        $request->validate([
            // 'find' => 'required|string|max:100|url|unique:news_url,url', 
            'find' => [
            'required',
            'string',
            'max:200',
            'unique:news_url,url',
            function ($attribute, $value, $fail) {
                // Cek jika input adalah URL
                if (filter_var($value, FILTER_VALIDATE_URL)) {
                    return true;
                }
                // Cek jika input adalah nomor telepon
                if (preg_match('/^(\+|0)[0-9]{9,13}$/', $value)) {
                    return true;
                }
                // Jika tidak memenuhi salah satu, gagal
                $fail('The ' . $attribute . ' must be a valid URL or phone number.');
            },
        ],
            'title' => 'required|string|max:200', // Memvalidasi input 'title'
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024', // Maksimal 1 MB
            
        ], [
            'find.unique' => 'Alamat URL sudah ada di database.', // Pesan error kustom untuk URL duplikat
            'find.required' => 'Kolom URL harus diisi.',
            'title.required' => 'Kolom judul harus diisi.',
            'image.max' => 'Gambar tidak boleh lebih dari 1MB.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, webp, atau gif.',    
        ]);

       // Ambil metadata dari session yang sudah disimpan di view search
        $metadata = session('metadata');
        $imageUrl = session('metadata_image') ?? null;
        $localImagePath = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $uploadedImage = $request->file('image');
            $imageName = Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('image', $uploadedImage, $imageName);
            $localImagePath = 'image/' . $imageName;
        } elseif (session('metadata_image')) {
            $imageContents = Http::get($imageUrl)->body();
            $imageName = 'image/' . Str::random(20) . '.jpg';
            Storage::disk('public')->put($imageName, $imageContents);
            $localImagePath = $imageName;
        }
        
        // Bersihkan HTML berbahaya dari judul dan deskripsi
         $cleanUrl = HtmlSanitizer::sanitize($request->input('find'));
         $cleanTitle = HtmlSanitizer::sanitize($request->input('title'));
         $cleanDescription = HtmlSanitizer::sanitize($request->input('description'));
        
 
        //  // Periksa apakah masih ada tag berbahaya
        //  if (preg_match('/<script|<iframe|<object|onload=|onerror=/', $cleanTitle) || preg_match('/<script|<iframe|<object|onload=|onerror=/', $cleanTitle)) {
        //      return redirect()->back()->with('error', 'Judul atau judul mengandung elemen HTML berbahaya!');
        //  }
        // Gabungkan pengecekan untuk title dan description
        if (preg_match('/<script|<iframe|<object|onload=|onerror=/', $cleanTitle) || 
            preg_match('/<script|<iframe|<object|onload=|onerror=/', $cleanDescription)) {
            return redirect()->back()->with('error', 'Judul atau deskripsi mengandung elemen HTML berbahaya!');
        }
 
        //dengan metode Eloquent karena perlu generate slug otomatis yg sudah ada di model urlnewsmodel 
        $newsUrl = NewsUrlModel::create([
            'url' => $cleanUrl,
            'title' => $cleanTitle,
            // 'desc' => $request->description ?? $metadata['description'], // Prioritaskan input user
            'desc' => $cleanDescription ?? $metadata['description'], // Prioritaskan input user
            'news_user_id' => auth()->id(), //rand(1, 60), // Sementara masih random
            'image_url' => $localImagePath ? asset('storage/' . $localImagePath) : null,
        ]);
        
        $find = $request->input('find');
        $searchKeyword = $request->input('title');
        session(['search_keyword' => $cleanUrl]);
        // dump($searchKeyword);
        // dump(session('search_keyword'));
        //session(['search_keyword' => $find]); // Simpan nilai find ke session jika diperlukan
        // Pastikan data tersimpan
        if ($newsUrl) {
            // return redirect()->route('caridulu')->with('success', 'Data URL baru berhasil disimpan.');
            
             // Redirect ke halaman produk setelah disimpan, dan menampilkan pesan sukses
            return redirect()->route('cari.showdetail',  [
                'id' => $newsUrl->id, 
                'title' => $newsUrl->title, 
                'urlslug' => $newsUrl->url_slug,
                ])->with('success', 'Link baru berhasil disimpan!');
        }
        return back()->with('error', 'Gagal menyimpan link.');    

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
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:100', // Maksimal 100 KB
            ], [
                'image.max' => 'Gambar tidak boleh lebih dari 100KB.',
                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, webp, atau gif.'
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
            'news_user_id' => auth()->id(), //rand(1, 60), // sementara masih tembak langsung
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
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:100', // Maksimal 100 KB
            ], [
                'image.max' => 'Gambar tidak boleh lebih dari 100KB.',
                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, webp, atau gif.'
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
            'news_user_id' => auth()->id(), //rand(1, 60), // sementara masih tembak langsung
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
            // $description = $xpath->query("//meta[@property='og:description']")->item(0)?->getAttribute('content') ??
            //             $xpath->query("//meta[@name='description']")->item(0)?->getAttribute('content');
            $author = $xpath->query("//meta[@name='author']")->item(0)?->getAttribute('content');
            $publishDate = $xpath->query("//meta[@property='article:published_time']")->item(0)?->getAttribute('content') ??
                       $xpath->query("//meta[@name='publish_date']")->item(0)?->getAttribute('content');

            // Ambil Metadata di <head>
            $metaDescription = $xpath->query("//meta[@name='description']")?->item(0)?->getAttribute('content') ?? '';
            $ogDescription = $xpath->query("//meta[@property='og:description']")?->item(0)?->getAttribute('content') ?? '';
            
            // Ambil Data di <body>
            $bodyContent = '';
            $paragraphs = $xpath->query("//p | //div[contains(@class, 'description')]");
            foreach ($paragraphs as $p) {
                $bodyContent .= trim($p->nodeValue) . ' ';
            }

            // Gabungkan metadata dan konten DOM
            $description = $metaDescription ?: $ogDescription ?: $bodyContent;
            $fullDescription = $description . ' ' . $bodyContent;

            return [
                'title' => $title,
                'image' => $image,
                'description' => $fullDescription, //$description,
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
        'reply_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:100',
        ], [
            'reply_image.max' => 'File gambar yang diunggah tidak boleh lebih dari 100KB.', // Custom message for max size
        ]);
    // Proses penyimpanan file gambar jika ada
    $imagePath = null;
    $storedPath = null;
    if ($request->hasFile('reply_image')) {
        // Simpan file gambar di folder storage dan dapatkan pathnya
        $storedPath = $request->file('reply_image')->store('reply_images', 'public');
        // dd($storedPath);
    }

    DB::table('comment_replies')->insert([
        'comment_id' => $commentId,
        'user_id' => auth()->id(), //rand(1, 50), // Assuming user is authenticated
        'reply_text' => $request->input('reply_text'),
        // 'created_at' => now(),  // Manual timestamp
        // 'updated_at' => now(),  // Manual timestamp
        // 'image_reply' => $imagePath, // Menyimpan path gambar jika ada
        // 'image_reply' => $storedPath, // Menyimpan path gambar jika ada
        'image_reply' => $storedPath ? asset('storage/' . $storedPath) : null,
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
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:100', // Maksimal 100 KB
            ], [
                'image.max' => 'Gambar tidak boleh lebih dari 100KB.',
                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, webp, atau gif.'
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
            'news_user_id' => auth()->id(), //rand(1, 60), // sementara masih tembak langsung
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
        $validator = Validator::make($request->all(), [
           
            'product_name' => 'required|max:255',
            'product_description' => 'nullable|string', // HTML editor disimpan sebagai string
            'product_price' => 'required|numeric',
            'product_contact_number' => ['required', 'string','regex:/(\+62|62|0)8[1-9][0-9]{9,15}$/'],
            'product_images' => 'required|array|max:5',
            'product_images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:200',
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
        $product->product_user_id = auth()->id(); //rand(1, 50);
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
                $product->save(); // Slug akan otomatis di-generate
            }

            // //baru simpan QR code saat tambah dan simpan produk baru
            // // Generate URL untuk produk
            // $productUrl = route('product.show', ['id' => $product->id, 'product_slug' => Str::slug($product->product_slug)]);
            // dump($productUrl);
            // // Generate QR code
            // $qrCodePath = "qrcodes/qr_{$product->id}.png";
            // QrCode::format('png')
            //     ->size(200)
            //     ->generate($productUrl, storage_path("app/public/{$qrCodePath}"));

            // // Simpan URL dan QR code path ke produk
            // $product->update([
            //     'url' => $productUrl,
            //     'product_image_qr' => asset("storage/{$qrCodePath}"),
            // ]);
            // // sampai disini codenya generate QR code dan simpan gambar QR

        // Redirect ke halaman produk setelah disimpan, dan menampilkan pesan sukses
        return redirect()->route('product.show',  [
            'id' => $product->id, 
            'product_slug' => $product->product_slug,
            ])->with('success', 'Produk berhasil disimpan!');
    }

    public function showdetailokold($id, $title)
    {
       
        //$keyword = $request->input('keyword');
        $keyword = $title;
        $keyid = $id;
        session(['news_url_id' => $id]); // Simpan ID ke session
        session(['search_keyword' => $title]); //simpan title ke session
       
        if (!empty($keyword)) {
                // Jika keyword ada, jalankan pencarian
                $news = Newsurlmodel::where('id', $keyid)
                ->with([
                    'comments_join' => function ($query) {
                        $query->orderBy('created_at', 'desc')->with('commentReplies');
                    },
                    'user'
                ])
                //->get();
                ->firstOrFail();
                // Tambahkan view count
                    $news->increment('views_count'); // viewed_count: kolom di database untuk jumlah dilihat
                  
                return view('showdetail', [
                    'newsurljoin' => $news,
                    'find' => $keyword,
            ]);
        }
    
    }

    public function showdetail($id, $title, $urlslug)
    {
       $url_slug = $urlslug;
        $keyword = session('search_keyword');
        // $keyword = $title;
        $keyid = $id;
        //dd($id, $title, $urlslug);
        session(['news_url_id' => $id]); // Simpan ID ke session
        session(['search_keyword' => $title]); //simpan title ke session
        session(['url_slug' => $url_slug]); //simpan title ke session
        // dump($id, $title, $urlslug);
        // if (!empty($keyword)) {
        if (!empty($url_slug)) {    
                // Jika keyword ada, jalankan pencarian
                // $news = Newsurlmodel::where('id', $keyid)
                $news = Newsurlmodel::where('url_slug', $url_slug)
                ->with([
                    'comments_join' => function ($query) {
                        $query->orderBy('created_at', 'desc')->with('commentReplies');
                    },
                    'user'
                ])
                ->firstOrFail();
            
                // Ambil data utama
                // $news = Newsurlmodel::where('url_slug', $url_slug)
                // ->with('user') // Hanya ambil relasi 'user'
                // ->firstOrFail();

                // // Paginate comments_join
                // $comments = $news->comments_join()
                // ->with('commentReplies') // Tambahkan relasi replies
                // ->orderBy('created_at', 'desc')
                // ->paginate(30);
                // $news = Newsurlmodel::where('url_slug', $url_slug)
                //     ->with(['user'])
                //     ->firstOrFail();

                // $comments = Comment::where('news_id', $news->id)
                //     ->with('commentReplies')
                //     ->orderBy('created_at', 'desc')
                //     ->paginate(30);

                

                // Tambahkan view count
                    $news->increment('views_count'); // viewed_count: kolom di database untuk jumlah dilihat
                  
                return view('showdetail', [
                    'newsurljoin' => $news,
                    'find' => $keyword,]);
                // return view('showdetail', [
                //     'newsurljoin' => $news,
                //     'find' => $keyword,   
                //     'comments' => $comments, ]);
            
        }
    else {
        $news = Newsurlmodel::where('id', $id)
                ->with([
                    'comments_join' => function ($query) {
                        $query->orderBy('created_at', 'desc')->with('commentReplies');
                    },
                    'user'
                ]) -> get();

            //  // Ambil data utama
            //  $news = Newsurlmodel::where('id', $id)
            //  ->with('user') // Hanya ambil relasi 'user'
            //  ->firstOrFail();

            //  // Paginate comments_join
            //  $comments = $news->comments_join()
            //  ->with('commentReplies') // Tambahkan relasi replies
            //  ->orderBy('created_at', 'desc')
            //  ->paginate(30);

                return view('showdetail', [
                    'newsurljoin' => $news,
                    'find' => $keyword,   
                
                // return view('showdetail', [
                //     'newsurljoin' => $news,
                //     'find' => $keyword,   
                //     'comments' => $comments, 
            ]);
    }
    }

    public function showdetaillazy($id, $title, $urlslug)
    {
       $url_slug = $urlslug;
        $keyword = session('search_keyword');
        // $keyword = $title;
        $keyid = $id;
        session(['news_url_id' => $id]); // Simpan ID ke session
        session(['search_keyword' => $title]); //simpan title ke session
        session(['url_slug' => $url_slug]); //simpan title ke session
      
        if (!empty($url_slug)) {    
                $news = Newsurlmodel::where('url_slug', $urlslug)
                ->with('user') // Load only the user relationship initially
                ->firstOrFail();
                
                $news->increment('views_count'); // Increment views count
                
                return view('showdetail2', [
                    'newsurljoin' => $news,
                    'find' => $keyword,]);
        }
    // else {
    //     $news = Newsurlmodel::where('id', $id)
    //             ->with([
    //                 'comments_join' => function ($query) {
    //                     $query->orderBy('created_at', 'desc')->with('commentReplies');
    //                 },
    //                 'user'
    //             ]) -> get();
    //             return view('showdetail', [
    //                 'newsurljoin' => $news,
                
    //         ]);
    //    }
    }

    // public function fetchComments(Request $request, $id)
    // {
    //     $comments = comments_join::where('news_id', $id)
    //         ->with('commentReplies', 'user') // Include necessary relationships
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(5); // Adjust per-page limit as needed
    //         dd($comments);

    //     if ($request->ajax()) {
    //         return view('partials.comments', compact('comments'))->render();  
    //     }

    //     return response()->json(['message' => 'Invalid request'], 400);
    // }

    public function fetchComments(Request $request, $id)
    {
        $comments = Comment::where('news_id', $id)
            ->with([
                'commentReplies' => function ($query) {
                    $query->orderBy('created_at', 'desc'); // Urutkan balasan
                },
                'user'
            ])
            ->orderBy('created_at', 'desc') // Urutkan komentar utama
            ->paginate(5); // Sesuaikan jumlah komentar per halaman

        if ($request->ajax()) {
            return view('partials.comments', compact('comments'))->render();
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }
    
    
    public function showproduct(Request $request, $id, $product_slug)
    { 
        // if ($request->query('source') === 'qr' && !Auth::check()) {
        //     return redirect()->route('login')->with('message', 'Please login to access this page.');
        // }
    
        $product = Product::where('id', $id)
                    ->where('product_slug', $product_slug)
                    ->firstOrFail();
        // Tambahkan view count
        $product->increment('product_viewed'); // viewed_count: kolom di database untuk jumlah dilihat

        // Generate QR Code URL
        $qrUrl = route('product.show', ['id' => $product->id, 'product_slug' => $product_slug]) . '?source=qr';

         // Cek apakah berasal dari QR Code
        $isFromQRCode = $request->query('source') === 'qr';
        if ($request->query('source') === 'qr') {
            $user = Auth::user();
            $ipAddress = $request->ip();
            Scans::create([
                'qr_code_id' => $id,
                'user_id' => $user?->id,
                'scanned_at' => now(),
                'ip_address' => $ipAddress,
                'scans_location' => $this->getLocationFromIp($ipAddress),
            ]);
        }    
        //return view('showproduct', compact('product')); 
        return view('showproduct', compact('product', 'qrUrl', 'isFromQRCode')); 
                  

    }


    public function saveProductUrlgaok(Request $request, $id)
    {
        // try {
            // Validasi input
            $request->validate([
                'url' => 'required|url|max:255',
            ]);
            
            // Temukan produk berdasarkan ID
            $product = Product::findOrFail($id);

            // Pastikan produk memiliki URL
            if (empty($product->url)) {
                return response()->json(['success' => false, 'message' => 'URL tidak tersedia untuk produk ini.']);
            }
            dump($product);
            // Buat QR code
            $qrCodePath = 'image-qr-codes/' . $product->id . '-qr.png';
            $qrCodeFullPath = storage_path('app/storage/app/public/' . $qrCodePath);

            QrCode::format('png')->size(300)->generate($product->url, $qrCodeFullPath);

            // Simpan path QR code ke database
            $product->update(['product_image-qr' => $qrCodePath]);

            return response()->json([
                'success' => true,
                'url' => asset('storage/image-qr' . $qrCodePath)
            ]);
        // }    
    }

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

            // // Ensure the directory exists
            // $qrCodeDir = storage_path('app/public/image-qr-codes/');
            // if (!is_dir($qrCodeDir)) {
            //     mkdir($qrCodeDir, 0755, true);
            // }
            // // Buat QR code
            // $qrCodePath = 'image-qr-codes/' . $product->id . '-qr.png';
            // $qrCodeFullPath = $qrCodeDir . $product->id . '-qr.png';
            // QrCode::format('png')->size(300)->generate($product->url, $qrCodeFullPath);
            // // Save the QR Code path in the database
            // $product->update(['product_image_qr' => 'storage/' . $qrCodePath]);

            // Kembalikan respon JSON sukses
            return response()->json(['message' => 'URL produk berhasil disimpan.']);
        } catch (\Exception $e) {
            // Tangani error dengan respon JSON
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan URL.', 'error' => $e->getMessage()], 500);
        }
    }


        public function addLike($id)
    {
        $news = Newsurlmodel::findOrFail($id);
        $news->increment('likes_count');
        return redirect()->route('cari.showdetail', ['id' => $news->id, 'title' => $news->title, 'urlslug' => $news->url_slug])
            ->with('success', 'Terima kasih telah menyukai!');
    }
    
    public function addLikeproduct($id)
    {
        $news = Product::findOrFail($id);
        $news->increment('product_liked');
        return redirect()->route('product.show', ['id' => $news->id, 'product_slug' => $news->product_slug])
            ->with('success', 'Terima kasih telah menyukai!');
    }

    public function incrementQrCountGenerated($id)
    {
        $product = Product::findOrFail($id); // Temukan produk berdasarkan ID
        $product->increment('product_generated_qr_count'); // Increment kolom `product_generated_qr_count`
        
        return response()->json(['success' => true, 'message' => 'QR count incremented successfully']);
    }

    public function incrementQrCodeScanned($id)
    {
        $product = Product::findOrFail($id); // Temukan produk berdasarkan ID
        $product->increment('product_qr_code_scanned'); // Increment kolom `product_qr_code_scanned`
        
       return response()->json(['success' => true, 'message' => 'QR count incremented successfully']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:100', // Validasi file avatar
    
        ]);
        
        $ipAddress = $request->ip();
        //$ipAddress = '182.233.46.233'; //tembak langsung
        $userAgent = $request->header('User-Agent');
        // Mendapatkan lokasi berdasarkan IP menggunakan layanan pihak ketiga (misalnya ipinfo.io)
        $location = $this->getLocationFromIp($ipAddress);
        $localImagePath = null;
        if ($request->hasFile('avatar')) {
            $uploadedImage = $request->file('avatar');
            $imageName = Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('imageavatar', $uploadedImage, $imageName);
            $localImagePath = 'imageavatar/' . $imageName;
        }
        // dd($localImagePath);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => \Str::random(30),

            'user_ip' => $ipAddress,
            'user_agent' => $userAgent,
            'user_location' => $location,  // Menyimpan informasi lokasi
            'user_avatar' => $localImagePath ? asset('storage/' . $localImagePath) : null, // Simpan URL gambar
        ]);

       
        Auth::login($user);
        $token = $user->remember_token;
        Cookie::queue('user_token', $token, 43200); // Cookie bertahan selama 30 hari
        // return redirect()->back()->with('success', 'User registered and logged in successfully');
        return redirect('login')->with('success', 'User registered successfully, please login to continue..');

    }

    // Fungsi untuk mendapatkan lokasi berdasarkan IP menggunakan ipinfo.io
    protected function getLocationFromIp($ipAddress)
    {
        try {
            // Menggunakan ipinfo.io untuk mendapatkan lokasi berdasarkan IP
            $response = Http::get("http://ipinfo.io/{$ipAddress}/json");
            //dump($response);
            if ($response->successful()) {
                $data = $response->json();
                return "{$data['city']}, {$data['region']}, {$data['country']}";
            }
        } catch (\Exception $e) {
            // Tangani error atau log jika perlu
            return 'Unknown location';
        }
    }

    public function showLoginForm(Request $request)
    {
         // Simpan URL halaman sebelumnya ke dalam session jika belum disimpan
         if (!$request->session()->has('url.intended')) {
            $request->session()->put('url.intended', url()->previous());
        }
        
        return view('auth.login');
    }

    public function showLoginFormAdmin(Request $request)
    {
         // Simpan URL halaman sebelumnya ke dalam session jika belum disimpan
         if (!$request->session()->has('url.intended')) {
            $request->session()->put('url.intended', url()->previous());
        }
        
        return view('auth.loginadmin');
    }

    //LOGIN
    public function login(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        // Ambil user berdasarkan email
        //$user = User::where('email', $request->email)->first();

        
         if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $token = Auth::user()->remember_token;
             // Menyimpan token ke cookie menggunakan Cookie facade Laravel
            Cookie::queue('user_token', $token, 43200); // Cookie bertahan selama 30 hari
            
            // Redirect ke halaman sebelumnya
            return redirect()->intended()->with('success', 'User logged in successfully!');
        
        }
        
        return redirect()->back()->with('message', 'Invalid credentials');

    }


    // public function login2(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //     ]);

    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $token = Auth::user()->remember_token;
    //         setcookie('user_token', $token, time() + (86400 * 30), "/"); // Cookie 30 hari

    //         return response()->json([
    //             'message' => 'User logged in successfully',
    //             'token' => $token,
    //         ])->withHeaders([
    //             'Authorization' => $token
    //         ]);
           
    //     }

    //     return response()->json([
    //         'message' => 'Invalid credentials'
    //     ], 401);
    // }

    // public function beranda(Request $request)
    // {
       
    //     // Memeriksa apakah token 'user_token' ada di cookie
    //     $token = $request->cookie('user_token');
        
    //     dump($token);
    //     if ($token && Auth::check() && Auth::user()->remember_token === $token) {
    //         // Jika token ada di cookie dan sesuai dengan token pengguna yang terautentikasi, lanjutkan ke halaman beranda2
    //         return view('beranda2');
    //     } else {
    //         // Jika token tidak ada atau tidak valid, arahkan pengguna ke halaman login dengan pesan
    //         return redirect('login')->with('alert', 'Kamu harus login dulu');
    //     }
        
    // }

    // public function beranda2()
    // {
        
    //         //return view('user');
    //         return view('beranda');
    // }

     // Fungsi logout
     public function logout(Request $request)
     {
         // Hapus token pengguna dari cookie
         setcookie('user_token', '', time() - 3600, '/'); // Hapus cookie dengan waktu kadaluarsa di masa lalu
 
         // Logout pengguna dari aplikasi
         Auth::logout();
 
         // Arahkan ke halaman login dengan pesan sukses
         //return redirect()->route('home')->with('message', 'Logged out successfully');
         return back()->with('success', 'logout successfully!');
     }
    
     
    //TEXT
    public function aboutPage2()
    {
        $aboutText = File::get(resource_path('views/texts/about_us.txt'));
        return view('landingpage', compact('aboutText'));
    } 

    public function ourProject()
    {
        $projectText = File::get(resource_path('views/texts/our_project.txt'));
        return view('landingpage', compact('projectText'));
    } 

    public function landingprod()
    {
       
        return view('landingproduct');
    } 

    public function landing()
    {
        try {
            $contentPath = resource_path('views/texts/content.json');
            
            // Check if the file exists
            if (!File::exists($contentPath)) {
                abort(404, 'Content file not found.');
            }

            // Decode JSON content
            $content = json_decode(File::get($contentPath), true);
            //dd($content, $content['about_us']);
            session(['search_keyword' => NULL]);
            //   // Simpan URL halaman sebelumnya ke dalam session jika belum disimpan
            //      if (!$request->session()->has('url.intended')) {
            //         $request->session()->put('url.intended', url()->previous());
            //     }
            // Pass variables to the view
            return view('landingpage', [
                'aboutText' => $content['about_us'] ?? 'About content missing',
                'projectText' => $content['project'] ?? 'project content missing',
                'projectText2' => $content['project2'] ?? 'project2 content missing',
                'caraText' => $content['cara'] ?? 'How to content missing',
                'caraText2' => $content['cara2'] ?? 'How to content2 missing'
                
            ]);

        } catch (\Exception $e) {
            // Handle error gracefully
            return view('landingpage', ['error' => $e->getMessage()]);
        }
    }

    public function showuser()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updateuser(Request $request)
    {
        $user = Auth::user();
        //dd($request->all(), $request->file('avatar'));

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:100', // Max 100KB
        ]);
        //dd($request->hasFile('avatar'));
        // Update avatar
        if ($request->hasFile('avatar')) {
            if ($user->user_avatar) {
                //dd($user);
                // Delete old avatar
                Storage::disk('public')->delete($user->user_avatar);
            }
            $avatarPath = $request->file('avatar')->store('imageavatar', 'public');
            
            $user->user_avatar = url('storage/' . $avatarPath); // Tambahkan domain dengan fungsi url()
}
            //$user->user_avatar = $avatarPath;
            $avatarChanged = true; // Tandai bahwa avatar diubah
            //dd($avatarPath);
        

        // Update other fields
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($avatarChanged) {
            return redirect()->route('profile.show')->with('success', 'Profile and avatar updated successfully!');
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function downloadPDF()
    {
        // if (!file_exists($filePath)) {
        //     abort(404, 'File not found.');
        // }
        $filePath = storage_path('app/public/caratambahprodukbaru.pdf'); // Path ke file PDF
        $fileName = 'caratambahprodukbaru.pdf'; // Nama file untuk diunduh

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }
    public function previewPDF()
    {
        // if (!file_exists($filePath)) {
        //     abort(404, 'File not found.');
        // }
        $filePath = storage_path('app/public/caratambahprodukbaru.pdf'); // Path ke file PDF

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function storefeedback(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
        ]);
        $cleanTitle = HtmlSanitizer::sanitize($request->input('title'));
        $cleanDescription = HtmlSanitizer::sanitize($request->input('description'));
        $cleanCategory = HtmlSanitizer::sanitize($request->input('category'));

        // Feedback::create([
        //     'title' => $request->input('title'),
        //     'description' => $request->input('description'),
        //     'category' => $request->input('category'),
        //     'user_id' => Auth::id(), // Optional: Associate feedback with logged-in user
        // ]);

        Feedback::create([
            'title' => $cleanTitle,
            'description' => $cleanDescription,
            'category' => $cleanCategory,
            'user_id' => Auth::id(), // Optional: Associate feedback with logged-in user
        ]);

        return redirect()->route('feedback.index')->with('success', 'Feedback submitted successfully!');
    }

    public function vote(Request $request, $id)
    {
        
        $request->validate([
            'type' => 'required|in:up,down',
        ]);
        // dump($request, $id);
        $feedback = Feedback::findOrFail($id);
        // if (!$feedback) {
        //     return response()->json(['message' => 'Feedback not found'], 404);
        // }

        // Prevent duplicate votes
        $existingVote = Vote::where('feedback_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingVote) {
            $existingVote->update(['type' => $request->input('type')]);
        } else {
            Vote::create([
                'feedback_id' => $id,
                'user_id' => Auth::id(),
                'type' => $request->input('type'),
                'created_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Vote registered successfully']);
    }

    public function commentfeed(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        Comment::create([
            'feedback_id' => $id,
            'user_id' => Auth::id(),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function indexfeed()
    {
        $feedbacks = Feedback::with('user')->orderBy('created_at', 'desc')->paginate(9); // Mengambil umpan balik dengan relasi pengguna
        return view('feedback', compact('feedbacks'));
    }

    public function createfeedback()
    {
        return view('addfeedback');
    }

    public function mydashboard()
    {
        return view('mydashboard');
    }

    public function showNewsWithComments()
    {
        // Fetch news from the last 30 days
        $news = Newsurlmodel::with(['comments_join' => function ($query) {
            $query->where('created_at', '>=', now()->subDays(30))->orderBy('created_at', 'desc')
                ->with(['commentReplies' => function ($query) {
                    $query->where('created_at', '>=', now()->subDays(30));
                }]);
        }])->where('created_at', '>=', now()->subDays(30))->orderBy('created_at', 'desc')
        ->paginate(10);  
        // ->get();
        // dd($news->toArray());
        return view('dashboard.newscomment', compact('news'));
    }

    public function indexprod(Request $request)
    {
        
        // Sorting logic
        $sortBy = $request->get('sort_by', 'created_at');
        $direction = $request->get('direction', 'desc');

        $products = Product::select('products.*', 'users.name as username')
            ->leftJoin('users', 'products.product_user_id', '=', 'users.id')
            ->orderBy($sortBy, $direction)
            ->paginate(20);
            // dd($products);

        return view('dashboard.productsdashboard', compact('products'));
    }

    public function indexprodcari(Request $request)
    {
        $search = $request->input('search');

        // Query dasar dengan filter pencarian
        // $products = Product::with('user') // Relasi ke User
        //     ->when($search, function ($query, $search) {
        //         $query->where('product_name', 'like', "%{$search}%")
        //             ->orWhere('product_description', 'like', "%{$search}%")
        //             ->orWhereHas('user', function ($query) use ($search) {
        //                 $query->where('name', 'like', "%{$search}%");
        //             });
        //     })
        //     ->orderBy('created_at', 'desc') // Default sort
        //     ->paginate(20); // Pagination
            // dd($products);

            $products = DB::table('products')
            ->select('products.*', 'users.name as username') // Memilih semua kolom dari produk + username
            ->leftJoin('users', 'products.product_user_id', '=', 'users.id') // Gabungkan tabel produk dengan tabel users
            ->when($search, function ($query, $search) {
                $query->where('products.product_name', 'like', "%{$search}%")
                    ->orWhere('products.product_description', 'like', "%{$search}%")
                    ->orWhere('users.name', 'like', "%{$search}%"); // Filter pada kolom username
            })
            ->orderBy('products.created_at', 'desc') // Urutkan berdasarkan tanggal pembuatan
            ->paginate(20); // Batasi hasil dengan paginasi
            // dd($products);
        return view('dashboard.productsdashboard', compact('products', 'search'));
    }

    public function newsChart()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $newsData = Newsurlmodel::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
       
        // Siapkan data untuk grafik
        $chartData = [
            'labels' => $newsData->pluck('date'), // Tanggal sebagai label
            'data' => $newsData->pluck('count'), // Jumlah berita sebagai nilai
        ];
        if ($chartData['labels']->isEmpty()) {
            $chartData['labels'] = ['No Data'];
            $chartData['data'] = [0];
        }
       

        // dd($chartData);
        return view('dashboard.news_chart', compact('chartData'));
    }

    public function commentChart()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $newsDataComment = CommentsModel::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Siapkan data untuk grafik
        $chartDataComment = [
            'labels' => $newsDataComment->pluck('date'), // Tanggal sebagai label
            'data' => $newsDataComment->pluck('count'), // Jumlah berita sebagai nilai
        ];
        if ($chartDataComment['labels']->isEmpty()) {
            $chartDataComment['labels'] = ['No Data'];
            $chartDataComment['data'] = [0];
        }
        // dd($chartData);
        return view('dashboard.comment_chart', compact('chartDataComment'));
    }

    public function fourChart()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Data jumlah news link
        $newsData = Newsurlmodel::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Data jumlah comment
        $newsDataComment = CommentsModel::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Data jumlah reply
        $newsDataReply = CommentReply::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Data jumlah Search
        $newsDataSearch = SearchLog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
                
        // Data untuk chart kelima
        $searchTypeData = SearchLog::selectRaw('
                DATE(created_at) as date, 
                SUM(CASE WHEN search_type = "word" THEN 1 ELSE 0 END) as word,
                SUM(CASE WHEN search_type = "url" THEN 1 ELSE 0 END) as url,
                SUM(CASE WHEN search_type = "numeric" THEN 1 ELSE 0 END) as `numeric`,
                SUM(CASE WHEN search_type = "product" THEN 1 ELSE 0 END) as product
            ')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Tambahkan jumlah total untuk semua kategori
        $totalSearchTypeCount = $searchTypeData->reduce(function ($carry, $item) {
            return $carry + $item->word + $item->url + $item->numeric + $item->product;
        }, 0);
    
        // Siapkan data untuk grafik
        // Format data untuk chart.js
        $chartData = [
            'news' => [
                'labels' => $newsData->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M')),
                'data' => $newsData->pluck('count')->toArray(),
            ],
            'comments' => [
                'labels' => $newsDataComment->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M')),
                'data' => $newsDataComment->pluck('count')->toArray(),
            ],
            'replies' => [
                'labels' => $newsDataReply->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M')),
                'data' => $newsDataReply->pluck('count')->toArray(),
            ],
            'search' => [
                'labels' => $newsDataSearch->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M')),
                'data' => $newsDataSearch->pluck('count')->toArray(),
            ],
            'search_type' => [
            'labels' => $searchTypeData->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M')),
            'word' => $searchTypeData->pluck('word')->toArray(),
            'url' => $searchTypeData->pluck('url')->toArray(),
            'numeric' => $searchTypeData->pluck('numeric')->toArray(),
            'product' => $searchTypeData->pluck('product')->toArray(),
            ],
        ];
        // Menghitung jumlah data
    $counts = [
        'news_count' => $newsData->sum('count'),
        'comments_count' => $newsDataComment->sum('count'),
        'replies_count' => $newsDataReply->sum('count'),
        'search_logs_count' => $newsDataSearch->sum('count'),
        'totalSearchTypeCount' => $totalSearchTypeCount,
    ];
        // dd($chartData);
        return view('dashboard.fourchart', compact('chartData','counts'));
    }

    public function loadYearlyData()
    {
        $startDate = now()->subMonths(11)->startOfMonth();
        $endDate = now()->endOfMonth();

        $yearlyData = collect();
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths($i);
            $year = $date->year;
            $month = $date->month;

            $yearlyData->push([
                'month' => $date->format('F Y'),
                'news' => Newsurlmodel::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count(),
                'comments' => CommentsModel::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count(),
                'replies' => CommentReply::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count(),
                'search' => SearchLog::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count(),
            ]);
        }
        
        return response()->json(['yearlyData' => $yearlyData]);
    }

    
    
    // Proses otorisasi untuk admin
    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();
        // $role = $user->role;
        // Cek apakah user ada, role-nya admin (role = 1), dan password benar
        if ($user && $user->role == 1 && Hash::check($request->password, $user->password)) {
            Auth::login($user); // Login user
            $token = Auth::user()->remember_token;
            // Menyimpan token ke cookie menggunakan Cookie facade Laravel
            Cookie::queue('user_token', $token, 43200); // Cookie bertahan selama 30 hari
            return view ('mydashboard');

        // } elseif ($user && Hash::check($request->password, $user->password)) {
        //     Auth::login($user); // Login user
        //     $token = Auth::user()->remember_token;
        //     // Menyimpan token ke cookie menggunakan Cookie facade Laravel
        //     Cookie::queue('user_token', $token, 43200); // Cookie bertahan selama 30 hari
        //     $role = $user->role ?? ''; // Set default role jika NULL
        //     return view ('myuserdashboard');
        }    

        // Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors(['login' => 'Email atau password salah, atau Anda bukan admin.']);
    }

    public function indexFeedback(Request $request)
    {
        // Handle sorting
        $sortBy = $request->get('sort_by', 'id'); // Default sort column
        $direction = $request->get('direction', 'asc'); // Default direction

        // Fetch feedback with relations and sort
        // $feedbacks = Feedback::with('user', 'votes')
        //     ->withCount([
        //         'votes as upvotes' => function ($query) {
        //             $query->where('type', 'up');
        //         },
        //         'votes as downvotes' => function ($query) {
        //             $query->where('type', 'down');
        //         },
        //     ])
        //     ->orderBy($sortBy, $direction)
        //     ->paginate(10);
        $feedbacks = Feedback::select('feedbacks.*', 'users.name as username')
        ->leftJoin('users', 'feedbacks.user_id', '=', 'users.id') // Add join for user name
        ->orderBy(request('sort_by', 'created_at'), request('sort_direction', 'desc')) // Default sorting
        ->paginate(20);
    


        return view('dashboard.feedback_detail', compact('feedbacks', 'sortBy', 'direction'));
    }
    
    public function userGrowth()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Ambil data jumlah user yang registrasi per hari
        $userGrowthData = User::selectRaw('
            DATE(created_at) as date, 
            COUNT(*) as count
        ')
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Siapkan data untuk chart.js
        $chartData = [
            'labels' => $userGrowthData->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M')),
            'data' => $userGrowthData->pluck('count')->toArray(),
        ];

        return view('dashboard.usergrowth', compact('chartData'));
    }

   

}