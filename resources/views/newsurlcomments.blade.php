<!DOCTYPE html>
<html>
<head>
	<title>Tutorial Laravel #23 : Relasi One To One Eloquent</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
 
	
	<!-- Menampilkan URL dan Title di bagian paling atas jika ada hasil pencarian -->
    @if(!empty($newsurljoin) && count($newsurljoin) > 0)
        <div>
            <h3>URL PENCARIAN ANDA : {{ $newsurljoin[0]->url }}</h3> <!-- Menampilkan URL -->
            <h4>JUDUL URL : {{ $newsurljoin[0]->title }}</h4> <!-- Menampilkan Title -->
        </div>

        <!-- Menampilkan daftar komentar terkait dengan URL yang dicari -->
        <h4>Daftar Komentar:</h4>
		
        @foreach($newsurljoin as $news)
            @if($news->comments_join->isEmpty())
                <p>Tidak ada komentar.</p>
            @else
                <ul>
				
                    @foreach($news->comments_join as $comment)
					<!-- {{ var_dump($comment) }} Menampilkan data tanpa menghentikan eksekusi -->
					<br>
                        <li>{{ $comment->comment_text }}</li> <!-- Menampilkan komentar -->
						<li>{{ $comment->user_id }}</li> <!-- Menampilkan komentar -->
						<li><strong>Created at: </strong>{{ $comment->created_at }}</li> <!-- Menampilkan tanggal komentar -->
						@if($comment->user)
                        	<li><strong>User:</strong> {{ $comment->user->name }}</li> <!-- Nama user -->
						@else
							<li><strong>User:</strong> Tidak dikenal</li>
						@endif
						
                    @endforeach
                </ul>
            @endif
        @endforeach
    @else
        <div class="alert alert-danger" style="color: red;">
        <p>Tidak ada hasil yang ditemukan untuk pencarian ini.</p>
        <br>
        <a href="/home/addnewurl">Silahkan klik disini jika ingin menambah data</a>
    @endif
 
</body>
</html>