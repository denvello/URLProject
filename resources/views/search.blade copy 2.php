<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEK URL AH [cekurlah.com]</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 30px;
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
        input[type="text"]:not(:placeholder-shown) ~ .clear-btn {
         display: inline; /* Tampilkan tombol saat ada teks */
        }
    </style>
</head>
<body>
    <!-- Menampilkan logo -->
    <img src="{{ asset('img/cekduluah.png') }}" alt="Logo" class="logo"> <!-- Ubah path sesuai lokasi logo Anda -->
    <!-- Form untuk pencarian -->
    <form action="{{ route('cari.search') }}" method="POST">
        @csrf
        <div class="search-container">
        <input type="text" name="find" placeholder="Masukkan alamat url / kata kunci pencarian..." required value="{{ old('find', session('search_keyword', '')) }}">
        <span class="clear-btn" onclick="clearSearch()">×</span>
        </div>
        <br>
        <input type="submit" value="Cari">
        
    </form>
    <br>
    <a href="/addnewurlbaru">Tambah URL Baru</a>
    <a href="{{ route('cari.reset') }}">Reset Pencarian</a>
    <a href="/cari/index">Index URL Terbaru</a>

    <!-- Pesan kesalahan jika tidak ada input -->
    @if ($errors->has('find'))
        <div style="color: red;">
            {{ $errors->first('find') }}
        </div>
    @endif

    <!-- Menampilkan hasil pencarian -->
    @if(!empty($newsurljoin) && $newsurljoin->count() > 0) 
      <h4>PENCARIAN URL : {{ $newsurljoin[0]->id }} , {{ $newsurljoin[0]->url }}</h4> <!-- Menampilkan URL -->
        <h4>JUDUL URL : {{ $newsurljoin[0]->title }}</h4> <!-- Menampilkan Title -->
       
         <!-- Menampilkan daftar komentar terkait dengan URL yang dicari -->
         <h4>Daftar Komentar :</h4>
		 <a href="/tambahkomen">   Tambah komen</a>
         <!-- <a href="{{ route('cari.tambahkomen', ['id' => $newsurljoin[0]->id]) }}">Tambah komen</a> -->
         
        @foreach($newsurljoin as $news)
        
            @if($news->comments_join->isEmpty())
                <p>Tidak ada komentar. - END OF COMMENT</p>
            @else
                <ul>
				
                @foreach($news->comments_join as $comment)
                <div style="border: 2px solid #000; padding: 10px; margin-bottom: 10px; text-align: left;"> <!-- Membungkus setiap komentar dalam kotak -->
                    <p>{{ $comment->comment_text }}</p> <!-- Menampilkan komentar -->

                    <p style="font-size: 10px;">
                        <strong>Dibuat tgl: </strong>{{ \Carbon\Carbon::parse($comment->created_at)->format('l, d M Y H:i') }}
                        @if($comment->user)
                            <span style="margin-left: 10px;"><strong>Oleh:</strong> {{ $comment->user->name }}</span>
                        @else
                            <span style="margin-left: 10px;"><strong>Oleh:</strong> Tidak dikenal</span>
                        @endif
                    </p>
                </div>
                @endforeach
                </ul>
            @endif
        @endforeach

    @elseif(isset($find))
        <!-- Menampilkan pesan jika tidak ada hasil -->
        <p>Tidak ada hasil yang ditemukan untuk pencarian "{{ $find }}"</p>
        
    @endif

    <!-- Debug Session (hanya untuk keperluan testing) -->
    @if(session('search_keyword'))
        <p>Session Keyword: {{ session('search_keyword') }}</p>
        <p>Session ID: {{ session('news_url_id') }}</p>
    @else
        <p>Session Keyword tidak ditemukan di view search.</p>
    @endif

</body>
</html>