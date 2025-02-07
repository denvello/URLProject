<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEK DULU AH![cekduluaja.com]</title>
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

        .search-container .clear-btn:hover {
            background-color: #c82333;
        }


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
            margin-top: 30px;
     
        }

        .comment-footer {
            font-size: 10px;
            text-align: right;
            margin-top: 15px;
            position: absolute;
            bottom: 10px; /* Jarak 10px dari garis bawah kontainer */
            right: 15px; /* Jarak dari kanan sesuai padding kontainer */
            
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
   

    <div class="container">
        <!-- Menampilkan logo -->
        <img src="{{ asset('img/cekduluajalogo.png') }}" alt="Logo" class="logo"> <!-- Ubah path sesuai lokasi logo Anda -->
        <!-- Form untuk pencarian -->
        <form action="{{ route('cari.search') }}" method="POST">
            @csrf
            <div class="search-container">
                <input type="text" name="find" placeholder="Masukkan alamat url / kata kunci pencarian..." required value="{{ old('find', session('search_keyword', '')) }}">
                <a href="{{ route('cari.reset') }}" >X</a>
                <input type="submit" value="Cari">  
            </div>
            <p>
             <!-- Tombol navigasi -->
            <div style="margin-top: 20px;">
                <a href="/cari/index" class="btn-link">Index Terbaru</a>
                <a href="/addnewproduct" class="btn-link">Tambah</a>
                
            </div>
        </form>

            @if(session('success'))
            <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
            @endif

            <br>

            <!-- Tampilkan hasil metadata jika ada -->
            @if(!empty($metadata))
                <div class="metadata-results">
                    <h4>Metadata dari URL:</h4>
                    <p><strong>Judul:</strong> {{ $metadata['title'] ?? 'Tidak tersedia' }}</p>
                    <p><strong>Gambar:</strong> 
                        @if(!empty($metadata['image']))
                            <img src="{{ $metadata['image'] }}" alt="Gambar dari metadata" style="width:200px;">
                        @else
                            Tidak tersedia
                        @endif
                    </p>
                    <p><strong>Deskripsi:</strong> {{ $metadata['description'] ?? 'Tidak tersedia' }}</p>
                    <p><strong>Penulis:</strong> {{ $metadata['author'] ?? 'Tidak tersedia' }}</p>
                    <p><strong>Tanggal Publikasi:</strong> {{ $metadata['publish_date'] ?? 'Tidak tersedia' }}</p>
                </div>
            @endif

        
            <!-- Pesan kesalahan jika tidak ada input -->
            @if ($errors->has('find'))
                <div style="color: red;">
                    {{ $errors->first('find') }}
                </div>
            @endif

            <!-- Menampilkan hasil pencarian -->
            @if(!empty($newsurljoin) && $newsurljoin->count() > 0) 
                <!-- <h4 style="color: red;">PENCARIAN URL : {{ $newsurljoin[0]->id }} , {{ $newsurljoin[0]->url }}</h4> Menampilkan URL -->
                    @if($newsurljoin[0]->image_url)
                        <img src="{{ $newsurljoin[0]->image_url }}" alt="Gambar dari {{ $newsurljoin[0]->title }}">
                    @else
                        <!-- <p>Gambar tidak tersedia.</p> -->
                        <p><img src="{{ asset('storage/image/no-image-crop.png') }}" alt="No image" style="max-width: 50%; height: 60%; "></p>
                    @endif

                <h4>JUDUL URL : {{ $newsurljoin[0]->title }}</h4> <!-- Menampilkan Title -->
                <h4>DESKRIPSI : {{ $newsurljoin[0]->desc }}</h4> <!-- Menampilkan deskripsi -->

                <h6 class="header-right">Oleh :  {{ $newsurljoin[0]->user ? $newsurljoin[0]->user->name : 'Tidak dikenal' }}  ,  
                    {{ $newsurljoin[0]->user ? $newsurljoin[0]->user->email : 'tidak ada email' }} , 
                    {{ \Carbon\Carbon::parse($newsurljoin[0]->created_at)->format('l, d M Y H:i') }}</h6> <!-- Menampilkan user id -->
                <!-- Menampilkan daftar komentar terkait dengan URL yang dicari -->
                <h4>Daftar Komentar :</h4>
                <div style="margin-top: 20px;">
                    <a href="/tambahkomen" class="btn-link">Tambah Komen</a>
                    <br>
                </div>
               
                @foreach($newsurljoin as $news)
                    @if($news->comments_join->isEmpty())
                        <p>***</p>
                    @else
                        <ul>   
                        @foreach($news->comments_join as $comment)
                            <div class="comment-container">
                                <div style="flex: 0 0 200px; margin-right: 30px; margin-top: 30px;">        
                                    @if($comment->image_comment)
                                    <img src="{{ $comment->image_comment }}" alt="Gambar Komentar" style="max-width: 100%; height: auto; margin-top: 30px;">
                                    
                                    @else
                                        <img src="{{ asset('storage/image/no-image-crop.png') }}" alt="No image" style="max-width: 50%; height: 60%; margin-top: 30px;">
                                            
                                    @endif
                                </div>
                                    <div class="comment-content">
                                    
                                        <p class="comment-text" style="text-align: justify;" id="comment-{{ $comment->id }}">
                                            {{ $comment->comment_text }}
                                        </p> <!-- Menampilkan komentar -->
                                        @if(mb_strlen($comment->comment_text) > 300) <!-- Ubah angka ini sesuai kebutuhan -->
                                            <span class="show-more" onclick="showMoreText({{ $comment->id }})">terus membaca >></span>
                                        @endif    
                                        <span class="show-replies" onclick="toggleReplies({{ $comment->id }})" id="toggle-replies-{{ $comment->id }}">Show Replies</span>
                                        
                                        <div class="comment-footer">
                                            <p>
                                            <!-- <p style="font-size: 10px; text-align: right; margin-top: 20px;"> -->
                                            <strong>Dibuat tgl: </strong>{{ \Carbon\Carbon::parse($comment->created_at)->format('l, d M Y H:i') }}
                                            @if($comment->user)
                                                <span style="margin-left: 10px;"><strong>Oleh:</strong> {{ $comment->user->name }}</span>
                                            @else
                                                <span style="margin-left: 10px;"><strong>Oleh:</strong> Tidak dikenal</span>
                                            @endif
                                            </p>
                                        </p>
                                    </div>
                                </div>    
                            </div>

                            <!-- Label "Balas" untuk memunculkan form -->
                            <p class="reply-label" class="btn-link" onclick="showReplyForm({{ $comment->id }})">Balas</p>
                            <!-- Tambahkan script JavaScript untuk mengontrol tampilan form balasan -->
                            <script>
                                function showReplyForm(commentId) {
                                    var form = document.getElementById('reply-form-' + commentId);
                                    form.style.display = form.style.display === 'none' ? 'block' : 'none';
                                }
                            </script>
                        
                            <!-- Form balasan komentar yang muncul saat diklik --> 
                            <form id="reply-form-{{ $comment->id }}" class="reply-form" action="{{ route('comments.reply', $comment->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <textarea name="reply_text" placeholder="Tulis balasan..." required rows="3" cols="100"></textarea>
                                <input type="file" name="reply_image" accept="image/*">
                                <button type="submit">Kirim Balasan</button>
                            </form>


                            <!-- Menampilkan balasan komentar jika ada -->
                            @if($comment->commentReplies->count() > 0)
                                <div class="replies" style="margin-top: 5px;" id="replies-{{ $comment->id }}">
                                    <!-- <h5>Balasan:</h5> -->
                                    @foreach($comment->commentReplies as $reply)
                                        <div class="reply-container">
                                            <div style="flex: 0 0 200px; margin-right: 30px;">
                                                    @if($reply->image_reply)
                                                        <img src="{{ $reply->image_reply }}" alt="Image Reply" style="max-width: 70%; height: auto;">
                                                    @else
                                                        <img src="{{ asset('storage/image/no-image-avail.png') }}" alt="No image" style="max-width: 100%; height: auto;">
                                                    @endif
                                            </div>
                                            <div class="reply-content">
                                                <p>>> <em>{{ $reply->reply_text }}</em></p>
                                                <div class="reply-footer">
                                                    
                                                    <p><small><strong>Dibuat tgl: </strong>: {{ \Carbon\Carbon::parse($reply->created_at)->format('l, d M Y H:i') }}</small>
                                                    <span style="margin-left: 10px;"><strong>Oleh: </strong><small>{{ $reply->user->name }}</small></span>
                                                    </p>
                                                </div>        
                                            </div>
                                        </div>    
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </ul>
                    @endif
                @endforeach

            @elseif(isset($find))
                <!-- Menampilkan pesan jika tidak ada hasil -->
                <div class="comment-label">
                    <p>"{{ $find }}" belum ditambahkan kedalam database, mau ditambahkan?</p>
                </div>
                <p><a href="/cari/addnewurlbaru" class="btn">Tambah URL Baru</a></p>
                <!-- <a href="/cari/addnewurlbaru">| Tambah URL Baru |</a> -->
            
            @endif
    
</div>                     
</body>
</html>