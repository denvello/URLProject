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

   
    </style>
</head>
<body>
    <!-- Menampilkan logo -->
    <img src="{{ asset('img/cekduluaja.png') }}" alt="Logo" class="logo"> <!-- Ubah path sesuai lokasi logo Anda -->
    <!-- Form untuk pencarian -->
    <form action="{{ route('cari.search') }}" method="POST">
        @csrf
        <div class="search-container">
        <!-- <input type="text" name="find" placeholder="Masukkan alamat url / kata kunci pencarian..." required value="{{ old('find', session('search_keyword', '')) }}"> -->
        <input type="text" name="find" value="{{ $newsurljoin[0]->title ?? '' }}">


        <!-- <span class="clear-btn" onclick="clearSearch()">×</span> -->
        <a href="{{ route('cari.reset') }}" >X</a>
        </div>
        <br>
        <input type="submit" value="Cari">
        
    </form>
    <br>
    <a href="/cari/addnewurlbaru">| Tambah URL Baru |</a>
    <!-- <a href="{{ route('cari.reset') }}">Reset Pencarian</a> -->
    <a href="/cari/index"> Index URL Terbaru |</a>

    <!-- Pesan kesalahan jika tidak ada input -->
    @if ($errors->has('find'))
        <div style="color: red;">
            {{ $errors->first('find') }}
        </div>
    @endif

    <!-- Menampilkan hasil pencarian -->
    @if(!empty($newsurljoin) && $newsurljoin->count() > 0) 
      <h4 style="color: blue;">PENCARIAN URL : {{ $newsurljoin[0]->id }} , {{ $newsurljoin[0]->url }}</h4> <!-- Menampilkan URL -->
      @if($newsurljoin[0]->image_url)
                    <!-- Tampilkan gambar dari URL yang disimpan di database -->
                    <!-- <img src="{{ $newsurljoin[0]->image_url }}" alt="Gambar dari {{ $newsurljoin[0]->title }}" style="max-width: 400px;"> -->
                    <img src="{{ $newsurljoin[0]->image_url }}" alt="Gambar dari {{ $newsurljoin[0]->title }}" style="max-width: 400px;">
                @else
                    <p>Gambar tidak tersedia.</p>
                @endif

      
      
        <h4>JUDUL URL : {{ $newsurljoin[0]->title }}</h4> <!-- Menampilkan Title -->
        <h6 class="header-right">Oleh :  {{ $newsurljoin[0]->user ? $newsurljoin[0]->user->name : 'Tidak dikenal' }}  ,  
            {{ $newsurljoin[0]->user ? $newsurljoin[0]->user->email : 'tidak ada email' }} , 
            {{ \Carbon\Carbon::parse($newsurljoin[0]->created_at)->format('l, d M Y H:i') }}</h6> <!-- Menampilkan user id -->
         
            <!-- Menampilkan daftar komentar terkait dengan URL yang dicari -->
         <h4>Daftar Komentar :</h4>
		 <a href="/tambahkomen">   Tambah komen</a>
         <!-- <p>Session ID: {{ $newsurljoin[0]->id }}</p>  -->
        @foreach($newsurljoin as $news)
        
            @if($news->comments_join->isEmpty())
                <p>Tidak ada komentar. - END OF COMMENT</p>
            @else
                <ul>
				
                @foreach($news->comments_join as $comment)
                <!-- <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; text-align: left;"> Membungkus setiap komentar dalam kotak -->
                <div style="display: flex; align-items: flex-start; margin-bottom: 30px; border: 1px solid #ddd; padding: 20px;">    
                    @if($comment->image_comment)
                        <div style="flex: 0 0 200px; margin-right: 30px;">
                                    <p><strong>Gambar:</strong></p>
                                    <img src="{{ $comment->image_comment }}" alt="Gambar Komentar" style="max-width: 100%; height: auto;">
                        </div>
                    @else
                        <div style="flex: 0 0 200px; margin-right: 15px;">
                            <p>Tidak ada gambar.</p>
                        </div>
                    @endif
                    
                
                    <div style="flex: 1;">
                        <p style="text-align: justify;">{{ $comment->comment_text }}</p> <!-- Menampilkan komentar -->
                    
                        <p style="font-size: 10px; text-align: right; margin-top: 20px;">
                        <strong>Dibuat tgl: </strong>{{ \Carbon\Carbon::parse($comment->created_at)->format('l, d M Y H:i') }}
                        @if($comment->user)
                            <span style="margin-left: 10px;"><strong>Oleh:</strong> {{ $comment->user->name }}</span>
                        @else
                            <span style="margin-left: 10px;"><strong>Oleh:</strong> Tidak dikenal</span>
                        @endif
                        </p>
                    </div>
                </div>
                @endforeach
                </ul>
            @endif
        @endforeach

    @elseif(isset($find))
        <!-- Menampilkan pesan jika tidak ada hasil -->
        <p>Tidak ada hasil yang ditemukan untuk pencarian "{{ $find }}"</p>
        
    @endif
        <p style="color: red;"> Keyword dari data newsurljoin(0): {{ $newsurljoin[0]->url }}</p>
        <p style="color: red;"> dari data newsurljoin(0):: {{ $newsurljoin[0]->id }}</p> 
        <br>
        <br>
        <p>Session Keyword di IF: {{ session('search_keyword') }}</p>
        <p>Session ID di IF: {{ session('news_url_id') }}</p>

</body>
</html>