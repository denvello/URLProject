<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOW DETAIL![cekduluah.com]</title>
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

        .news-container {
            display: flex;
            flex-direction: column;
            background-color: #ffffff; /* Warna biru muda lembut #f9f9ff */
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 20px 0;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .news-image img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .news-title {
            font-size: 1.5em;
            /* background-color: #dbeafe; Highlight biru muda */
            background-color: #bcbcbc; /* Highlight abu muda */
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: center;
            color: #1f2937; /* Warna teks gelap */
        }

        .news-desc {
            font-size: 1em;
            color: #4b5563;
            margin-bottom: 10px;
            text-align: justify;
        }

        /* .news-author {
            font-size: 0.9em;
            color: #6b7280;
            text-align: left;
            margin-top: 10px;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        } */


        /* .submit-btn:hover {
            background-color: #0056b3;
        } */

        /* Modal container */
    .modal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 1000; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.8); /* Black w/ opacity */
    }

    /* Modal image */
    .modal-content {
        display: block;
        margin: auto;
        max-width: 90%;
        max-height: 90%;
        border: 2px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    /* Close button */
    .close-btn {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }
    
        .news-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 90%; /* Pastikan elemen memenuhi tinggi kontainer */
        position: relative;
    }

    .news-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        border-top: 1px solid #e5e7eb; /* Garis pemisah di atas footer */
        padding-top: 10px;
        margin-top: auto; /* Mendorong elemen footer ke bawah */
        font-size: 0.9em; /* Ukuran font kecil */
        color: #6b7280; /* Warna teks abu-abu */
        text-align: left;
    }

    .news-author,
    .news-date,
    .news-meta {
        font-size: 0.9em;
        margin: 0 5px 0 0; /* Jarak antar elemen horizontal */
    }

    .news-meta {
        display: flex; /* Membuat elemen di dalamnya dalam baris horizontal */
        justify-content: flex-end; /* Mengatur elemen menempel ke kanan */
        align-items: right; /* Vertikal rata tengah */
        gap: 10px; /* Jarak antar elemen */
        font-size: 0.9em;
    }
   

    .btn-liked {
        background-color: #bcbcbc; /* Warna merah */
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;

        font-size: 0.9em;
  
        background-color: #007bff;
   
    
    cursor: pointer;
    transition: background-color 0.3s;
    }

    .btn-liked:hover {
        background-color: #999999; /* Warna merah lebih gelap saat hover */
    }

    .views-count,
    .likes-count {
        font-size: 0.9em; /* Ukuran font kecil */
        color: #6b7280; /* Warna teks abu-abu */
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
   
    #loading-spinner {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 50px;
}

.loader {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-left-color: #999999;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}


    </style>
</head>
<body>
    <div class="container" style="position: relative;">
        @if(Auth::check() && Auth::user()->name)
            <div class="user-info">
                <span>Hi, {{ Auth::user()->name }}!</span>
                <form action="{{ route('logout') }}" method="GET" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        @endif
        <!-- Menampilkan logo -->
        <img src="{{ asset('img/cekduluah-crop-logo.png') }}" alt="Logo" class="logo"> <!-- Ubah path sesuai lokasi logo Anda -->
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
                <a href="/caridulu/showindexurl" class="btn-link">Index URL Terbaru</a>
                <!-- <a href="/cari/addnewproduct" class="btn-link">Promo Produk</a> -->
                <a href="/caridulu/showindexprod" class="btn-link">Daftar Promo</a>
                
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
            @if(!empty($newsurljoin) && $newsurljoin->count() > 0)
            <div class="news-container">
                        <div class="news-image">
                            @if($newsurljoin->image_url)
                                <img src="{{ $newsurljoin->image_url }}" alt="Gambar dari {{ $newsurljoin->title }}">
                            @else
                                <p><img src="{{ asset('storage/image/no-image-crop.png') }}" alt="No image" style="max-width: 50%; height: 60%; "></p>
                            @endif
                        </div>    
                        <div class="news-content">
                            <h4 class="news-title">{{ $newsurljoin->title }}</h4> <!-- Menampilkan Title -->
                            <p class="news-desc">{{ $newsurljoin->desc }}</p> <!-- Menampilkan deskripsi -->
                            <div class="news-footer">
                                <p class="news-author">
                                    Oleh: {{ $newsurljoin->user ? $newsurljoin->user->name : 'Tidak dikenal' }} 
                                    <!-- ({{ $newsurljoin->user ? $newsurljoin->user->email : 'tidak ada email' }}) //belum perlu email-->
                                    Tgl : {{ \Carbon\Carbon::parse($newsurljoin->created_at)->format('l, d M Y H:i') }}
                               </p>  
                            </div>
                            <p class="news-meta">
                                <span class="views-count">Dilihat: {{ $newsurljoin->views_count }}x</span>
                                <span class="likes-count">Disuka: {{ $newsurljoin->likes_count }}x</span>
                                <span>
                                <form action="{{ route('news.like', ['id' => $newsurljoin->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-liked">Like</button>
                                </form>
                                </span>
                            </p>
                        </div>
                    </div>
                    <!-- Modal Structure -->
                    <div id="imageModal" class="modal" onclick="closeModal()">
                        <span class="close-btn" onclick="closeModal()">&times;</span>
                        <img class="modal-content" id="modalImage">
                    </div>
                    <br>
                    <br> 
                    @if($newsurljoin->comments_join->isEmpty())
                    <p style="background-color: #cfe2f3; color: black; width: 95%; padding: 10px; text-align: center; margin: 0 auto;">
                        Yuk, apa komentar kamu nih Dul?
                    </p>
                        <div style="margin-top: 20px;">
                            <a href="/tambahkomen" class="btn-link">Tambah Komentar</a>
                            <br>
                        </div>
                    @else
                        <!-- Menampilkan daftar komentar terkait dengan URL yang dicari -->
                        <h4>Daftar Komentar :</h4>
                        <div style="margin-top: 20px;">
                            <a href="/tambahkomen" class="btn-link">Tambah Komentar</a>
                            <br>
                        </div>
                    
                        <!-- Tombol untuk menampilkan/menyembunyikan semua balasan -->
                        <button id="toggleAllReplies">Show All Replies</button>

                        <ul>
                        @php
                            $totalComments = $newsurljoin->comments_join->count(); // Hitung total komentar
                        @endphp    
                            @foreach($newsurljoin->comments_join as $index => $comment)
                                <div class="comment-container">   
                                    <!-- @include('partials.comments', ['comments' => collect([$comment])]) -->
                                </div>   
                            @endforeach
                    @endif
            @endif
            
            <div id="loading-spinner" style="display: none;">
                <div class="loader"></div>
            </div>

            @stack('scripts')

            
        <script>
            function showMoreText(commentId) {
                var commentText = document.getElementById('comment-' + commentId);
                if (commentText.classList.contains('expanded')) {
                    commentText.classList.remove('expanded');
                    event.target.textContent = 'terus membaca >>';
                } else {
                    commentText.classList.add('expanded');
                    event.target.textContent = 'Sembunyikan';
                }
            }

            function toggleReplies(commentId) {
                var repliesContainer = document.getElementById('replies-' + commentId);
                var toggleButton = document.getElementById('toggle-replies-' + commentId);

                if (repliesContainer.style.display === 'none' || repliesContainer.style.display === '') {
                    repliesContainer.style.display = 'block'; // Tampilkan replies
                    toggleButton.textContent = 'Hide Replies'; // Ubah teks tombol
                } else {
                    repliesContainer.style.display = 'none'; // Sembunyikan replies
                    toggleButton.textContent = 'Show Replies'; // Ubah teks tombol
                }
            }

            function toggleImageVisibilityReply(replyId) {
                const imageContainer = document.getElementById(`reply-image-${replyId}`);
                const toggleLink = document.getElementById(`toggle-reply-link-${replyId}`);

                if (imageContainer.style.display === 'none') {
                    imageContainer.style.display = 'block'; // Show image
                    toggleLink.textContent = 'Hide';
                } else {
                    imageContainer.style.display = 'none'; // Hide image
                    toggleLink.textContent = 'View Picture Reply';
                }
            }

            
            // Open Modal
            function openModal(imageSrc) {
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                modal.style.display = 'block'; // Show modal
                modalImage.src = imageSrc; // Set image source
            }

            // Close Modal
            function closeModal() {
                const modal = document.getElementById('imageModal');
                modal.style.display = 'none'; // Hide modal
            }

            function toggleImageVisibility(commentId) {
                const imageContainer = document.getElementById(`comment-image-${commentId}`);
                const toggleLink = document.getElementById(`toggle-link-${commentId}`);

                if (imageContainer.style.display === 'none') {
                    imageContainer.style.display = 'block'; // Show image
                    toggleLink.textContent = 'Hide Picture';
                } else {
                    imageContainer.style.display = 'none'; // Hide image
                    toggleLink.textContent = 'View Picture';
                }
            }

        </script>

        
</div>  
                   
</body>
</html>