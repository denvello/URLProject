<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cekduluaja.com</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/cekduluaja-kotak.png') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 30px;
        }

         /* Buttons */
         .btn {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1, h3, h4 {
            text-align: center;
            color: #333;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .search-container input[type="text"] {
            width: 40%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            font-size: 1rem;
        }
        .search-container .clear-btn {
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 0 5px 5px 0;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        /* .search-container .clear-btn:hover {
            background-color: #c82333;
        } */


        .search-container input[type="submit"],
        .search-container a {
            background-color: #999999;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            font-size: 1rem;
            text-align: center;
        }

        .search-container input[type="submit"]:hover,
        .search-container a:hover {
            background-color: #5b5b5b;
        }

        .search-container input[type="text"] {
            width: 40%; /* Lebar input pencarian */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box; /* Pastikan padding dihitung dalam lebar */
        }

        .search-container .clear-btn,
        .search-container .submit-btn {
            padding: 10px 15px; /* Padding seragam untuk tombol */
            font-size: 1rem; /* Ukuran font seragam */
            height: auto; /* Biarkan tombol menyesuaikan tinggi otomatis */
            line-height: 1.2; /* Pastikan teks di dalam tombol rata */
            display: flex; /* Gunakan flexbox untuk menyelaraskan konten */
            align-items: center; /* Pusatkan teks dalam tombol */
            justify-content: center; /* Pusatkan konten horizontal */
            box-sizing: border-box; /* Padding dihitung dalam dimensi tombol */
        }

        .search-container .clear-btn {
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-container .clear-btn:hover {
            background-color: #c82333;
        }

        .search-container .submit-btn {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-container .submit-btn:hover {
            background-color: #0056b3;
        }

        /* Metadata Results */
        .metadata-results {
            margin-top: 20px;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }

        .metadata-results img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
        }


        input[type="text"] {
            width: 400px;
            padding: 10px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            margin-top: 10px;
        }
        .search-results {
            margin-top: 20px;
            text-align: left;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        /* CSS untuk memusatkan konten */
        .center-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-height: 100vh;
        }

        /* Sesuaikan ukuran logo */
        .logo {
            max-width: 300px;
            margin-bottom: 10px;
        }

        .reply-label {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }
        .reply-form {
            display: none; /* Form input balasan tersembunyi secara default */
        }

        .comment-container { 
            display: flex;
            align-items: flex-start; /* Posisi elemen serupa dengan balasan */
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 95%; /* Lebar kotak komentar utama */
            margin-bottom: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 20px;
            position: relative; /* Membuat kontainer sebagai referensi untuk posisi absolut */    
        }

        .comment-content {
            flex: 1;
            text-align: justify;
        }

        .comment-image {
            width: 200px;
            height:200px;
            margin-right: 30px; /* Jarak antara gambar dan teks */
            /* flex: 0 0 200px;    */
     
        }

      

        /* Warna teks dan hover */
        .comment-text, .reply-text {
            font-size: 16px;
            color: #333333;
            /*fitur utk membatasi baris */
            max-height: 10em; /* Batas tinggi 10 baris */
            overflow: hidden;
            position: relative;
        }

        .comment-text.expanded {
            max-height: none; /* Tinggi penuh jika diperluas */
        }
        .show-more {
            color: blue;
            cursor: pointer;
            text-decoration: underline;
            display: block;
            margin-top: 5px;
        }

        .comment-label, .reply-label {
            color: #007bff;
            cursor: pointer;
        }

        .comment-label:hover, .reply-label:hover {
            text-decoration: underline;
            background-color: #e9e9e9;
        }

        .reply-container {
            width: 80%; /* Lebar kotak reply */
            border: 1px solid #ccc; /* Border untuk reply */
            padding: 10px;
            margin-top: 10px; /* Jarak antara kotak komentar dan reply */
            margin-bottom: 10px;
            
            display: flex;
            align-items: flex-start;
            margin-left: auto; /* Memindahkan elemen ke sisi kanan */
            margin-right: 30px;
            position: relative; /* Supaya footer bisa diatur posisinya relatif */
            background-color: #f1f1f1;
            border-radius: 8px;
        }

       .reply-image {
            width: 50px;
            height: 50px;
            margin-right: 10px; /* Jarak antara gambar dan teks */

        }

        .reply-content {
            flex: 1;
            text-align: justify;
        }

        .replies {
            flex: 1;
            /* text-align: justify; */
            display: none; /* Disembunyikan secara default */
        }

        .show-replies {
            color: blue;
            cursor: pointer;
            text-decoration: underline;
            display: block;
            margin-top: 5px;
        }

        .reply-footer {
            font-size: 10px;
            text-align: right;
            margin-top: 15px;
            position: absolute;
            bottom: 10px; /* Jarak 10px dari garis bawah kontainer */
            right: 15px; /* Jarak dari kanan sesuai padding kontainer */
            
        }
        /* Form balasan */
        .reply-form {
            display: none;
            margin-top: 10px;
        }

        .reply-form textarea {
            width: 80%;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #cccccc;
        }

        .reply-form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
        }

        .reply-form button:hover {
            background-color: #0056b3;
        }
        .btn-link {
        display: inline-block;
        background-color: #999999;
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        font-size: 1rem;
        border-radius: 5px;
        margin: 5px;
        transition: background-color 0.3s;
        }

        .btn-link:hover {
            background-color: #5b5b5b;
            text-decoration: none;
        }

        .btn-link.red {
            background-color: #dc3545;
        }

        .btn-link.red:hover {
            background-color: #c82333;
        }

        .btn-link.green {
            background-color: #28a745;
        }

        .btn-link.greydark {
            background-color: #5b5b5b;
        }

        .btn-link.green:hover {
            background-color: #218838;
        }

        .submit-container {
        text-align: center; /* Pusatkan tombol */
        margin-top: 10px;
        }

        .submit-container input[type="submit"] {
            width: 30%; /* Panjang tombol 50% dari kolom pencarian */
            padding: 10px;
            border: none;
            background-color: #5b5b5b;
            color: white;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-container input[type="submit"]:hover {
            background-color: #999999;
        }

        .submit-btn {
            /* background-color: #007bff; */
            color: white;
            padding: 10px 20px; /* Padding tombol submit */
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 200px; /* Panjang tombol bisa diatur secara bebas */
        }

        /* .submit-btn:hover {
            background-color: #0056b3;
        } */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .grid-item {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 15px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;

            cursor: pointer;
        }

        .grid-item:hover {
            transform: translateY(-5px);
            /* transform: scale(1.05); Sedikit perbesar ketika hover */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }


        /* Kontainer judul di dalam grid item */
        .grid-title {
            /* background-color: #f7f7f7; Warna awal */
            padding: 10px;
            text-align: center;
            transition: background-color 0.3s ease; /* Animasi perubahan warna */
        }

        .grid-title h4 {
            margin: 0;
            color: #333;
        }

         /* Warna berubah saat hover */
         .grid-item:hover .grid-title {
            background-color: #eeeeee; /* Warna abu muda */
        }

        .grid-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }

        .grid-item h4 {
            font-size: 1rem;
            margin: 10px 0 5px;
            color: #333;
        }

        .grid-item p {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }

        .comment-container {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        position: relative; /* Untuk memposisikan ikon di pojok kanan atas */
    }

    .comment-content {
        text-align: justify;
        margin-bottom: 20px; /* Memberikan jarak antara isi komentar dan footer */
    }

    .comment-footer {
        text-align: right; /* Teks rata kanan */
        margin-top: auto; /* Mendorong ke bawah */
        color: #555;
        font-size: 0.9rem;
        position: absolute;
        bottom: 5px; /* Jarak dari bawah */
        left: 10px; /* Jarak dari sisi kiri */
        right: 10px; Jarak dari sisi kanan
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px; /* Jarak antar elemen */

        
       
    }
    .comment-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: red;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
        }
       
        .comments-badge-red {
            background-color: red;
            position: absolute;
            top: 10px;
            right: 10px;
            /* background: red; */
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
        }

        .comments-badge-gray {
            background-color: gray;
            position: absolute;
            top: 10px;
            right: 10px;
            /* background: red; */
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
        }    
        
        .pagination {
            display: flex;
            justify-content: left;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 5px; /* Jarak antar halaman */
        }

        .pagination li a {
            display: inline-block;
            padding: 8px 12px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination li a:hover {
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
        }

        .pagination li.active span {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            padding: 8px 12px;
            border: 1px solid #007bff;
        }

        .section-header {
            background-color: #f2f2f2; /* Warna abu-abu muda lembut */
            width: 95%; /* Sepanjang 80% dari lebar kontainer */
            margin: 0 auto; /* Membuat elemen berada di tengah */
            padding: 10px; /* Tambahkan padding untuk estetika */
            text-align: center; /* Teks rata tengah */
            border-radius: 5px; /* Sudut melengkung */
            color: #333; /* Warna teks */
            font-weight: bold; /* Membuat teks lebih tegas */
        }
        
        .grid-item-meta { /*tidak dipakai */
            display: flex;
            justify-content: space-between;
            padding: 10px;
            font-size: 14px;
            color: #555;
        }

    .user-info {
        position: absolute;
        top: 10px;
        right: 10px; /* Posisikan di pojok kanan atas */
        text-align: right; /* Teks rata kanan */
    }

    .logout-btn {
        background-color: #dc3545; /* Warna merah untuk logout */
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        margin-left: 10px;
    }

    .logout-btn:hover {
        background-color: #c82333;
    }

    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ESM0Z1DLK4"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-ESM0Z1DLK4');
    </script>
</head>
<body>
    <div class="container" style="position: relative;">
        <div class="user-info">
            <!-- @if(Auth::check() && Auth::user()->name)
                <span>Hi, {{ Auth::user()->name }}!</span>
                <form action="{{ route('logout') }}" method="GET" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            @else 
                <span>...</span>  
            @endif -->
            @if(Auth::check() && Auth::user()->name)
                <!-- <span>Hi, {{ Auth::user()->name }}!</span> -->
                <span style="display: flex; gap: 5px; align-items: center;">
                    Hi,
                    <a href="{{ route('profile.show', Auth::user()->id) }}" style="text-decoration: none; color: inherit;">
                        {{ Auth::user()->name }}
                    </a>
                    <a href="{{ route('info.landing') }}" style="text-decoration: none; color: inherit;">
                       [?] 
                    </a>  
                </span>
                <form action="{{ route('logout') }}" method="GET" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            @else 
                <span style="display: flex; gap: 10px; align-items: center;">
                    <a href="{{ route('login') }}" style="text-decoration: none; color: inherit;">
                        <h4>...</h4>
                    </a> 
                    <a href="{{ route('info.landing') }}" style="text-decoration: none; color: inherit;">
                        <h4>[?]</h4>
                    </a>                            
                </span>
            @endif
        </div>
        
        <!-- Menampilkan logo -->
        <img src="{{ asset('img/cekduluajalogo.png') }}" alt="Logo" class="logo"> <!-- Ubah path sesuai lokasi logo Anda -->
        <!-- Form untuk pencarian -->
        <form action="{{ route('cari.searchdulu') }}" method="POST">
            @csrf
            <div class="search-container">
                <input type="text" name="find" placeholder="Masukkan alamat url / kata kunci pencarian..." required value="{{ old('find', session('search_keyword', '')) }}">
                <a href="{{ route('caridulu.reset') }}" >X</a>
                <input type="submit" value="Cari">  
            </div>
            <p>
             <!-- Tombol navigasi -->
            <div style="margin-top: 20px;">
                <a href="/showindexprod" class="btn-link">Daftar Promo</a>
                
            </div>
        </form>

            @if(session('success'))
            <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
            @endif

            <br>
            <!-- Pesan kesalahan jika tidak ada input -->
            @if ($errors->has('find'))
                <div style="color: red;">
                    {{ $errors->first('find') }}
                </div>
            @endif
            
            <!-- Menampilkan hasil pencarian -->
            @if(!empty($newsData) && $newsData->count() > 0)
                <h4 class="section-header">Daftar :</h4>
               
                <div class="grid-container">
                    @foreach($newsData as $arr_homeindexurl)
                        <div class="grid-item" onclick="location.href='{{ route('cari.showdetail', [$arr_homeindexurl->id,$arr_homeindexurl->title,$arr_homeindexurl->url_slug]) }}';" style="cursor: pointer;">       
                            <!-- <div class="comment-badge">{{ $arr_homeindexurl->comments_join_count }}</div> -->
                            @if($arr_homeindexurl->comments_join_count > 0)
                                <div class="comments-badge comments-badge-red">
                                    {{ $arr_homeindexurl->comments_join_count }}
                                </div>
                            @else
                                <div class="comments-badge comments-badge-gray">
                                    {{ $arr_homeindexurl->comments_join_count }}
                                </div>
                            @endif
                            @if($arr_homeindexurl->image_url)
                                <!-- <img src="{{ asset('storage/' . $arr_homeindexurl->image_url) }}" alt="Gambar dari {{ $arr_homeindexurl->title }}"> -->
                                <img src="{{ $arr_homeindexurl->image_url }}" alt="Gambar dari {{ $arr_homeindexurl->title }}">
                                    
                            @else
                                <img src="{{ asset('storage/image/no-image-crop.png') }}" alt="Gambar Tidak Tersedia">
                            @endif
                                <div class="grid-title">
                                    <h4>{{ $arr_homeindexurl->title }}</h4>
                                </div>
                                 <br>
                                <div class="comment-footer">
                                    <small>
                                        <!-- <strong>Dibuat:</strong>  -->
                                        {{ \Carbon\Carbon::parse($arr_homeindexurl->created_at)->diffForHumans() }}
                                    <span>
                                        <img src="{{ asset('img/viewed.png') }}" alt="Views" style="width: 16px; height: 16px; margin-right: 5px;">
                                            {{ $arr_homeindexurl->views_count }}
                                    </span>
                                    <span>
                                        <img src="{{ asset('img/liked.png') }}" alt="Likes" style="width: 16px; height: 16px; margin-right: 5px;">
                                            {{ $arr_homeindexurl->likes_count }}
                                        </span>
                                    </small>
                                </div>
                        </div>
                    @endforeach
                </div> 
                <div style="text-align: left; max-width: 80%%; margin: 20px auto;">
                    Halaman : {{ $newsData->currentPage() }} <br/>
                    Jumlah Data : {{ $newsData->total() }} <br/>
                    Data Per Halaman : {{ $newsData->perPage() }} <br/>
                    <br>
                    <div class="pagination-links">
                        {{ $newsData->links() }}
                    </div>
                </div> 
               
            @endif    
    </div>    
   
</body>
</html>