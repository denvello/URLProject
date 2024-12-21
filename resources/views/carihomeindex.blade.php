<!DOCTYPE html>
<html>
<head>
	<title>Beranda - Index</title>
</head>
<body>
     <!-- Menampilkan logo -->
     <img src="{{ asset('img/cekduluah.png') }}" alt="Logo" class="logo"> <!-- Ubah path sesuai lokasi logo Anda -->
    <style type="text/css">
		.pagination li{
			float: left;
			list-style-type: none;
			margin:5px;
		}
         /* Sesuaikan ukuran logo */
         .logo {
            max-width: 300px;
            margin-bottom: 10px;
        }
	</style>
	<h3>Daftar URL Terbaru</h3>
    <br>
	<a href="/cari">| Beranda |</a>
	<a href="javascript:history.back()"> Kembali |</a>	
	<br>
<!-- Menampilkan Data Hanya Jika Ada Hasil Pencarian -->
	@if(!empty($home_index) && count($home_index) > 0)
		<table border="1">
			<tr>
				<th>ID</th>
				<th>URL</th>
				<th>TITLE</th>
				<th>CREATED AT</th>		
			</tr>
		
				@foreach($home_index as $p)
				<tr>
					<td>{{ $p->id }}</td>
					<td>
						<a href="{{ $p->url }}" target="_blank" style="text-decoration: underline;">
						{{ $p->url }}
					</td>
					<td>
						<!-- <a href="{{ route('cari.searchid', ['id' => $p->title]) }}" style="text-decoration: underline;"> -->
						<a href="{{ route('cari', ['keyword' => urlencode($p->title)]) }}" style="text-decoration: underline;">	
						{{ $p->title }}

					
						
					</td>
					<!-- <td>{{ ($p->created_at) }}</td> -->
					<td>{{ \Carbon\Carbon::parse($p->created_at)->format('l, d M Y H:i') }}</td>
					
                    <td>
						<!-- <a href="/cari">view</a> -->
						<a href="{{ route('cari', ['keyword' => urlencode($p->title)]) }}" style="text-decoration: underline;">view</a>
						<a href="/news_url/hapus/{{ $p->id }}">Hapus</a>
					</td>
				</tr>
				@endforeach
		
		</table>
        <br/>
        Halaman : {{ $home_index->currentPage() }} <br/>
        Jumlah Data : {{ $home_index->total() }} <br/>
        Data Per Halaman : {{ $home_index->perPage() }} <br/>
        
        <div>
        {{ $home_index->links() }}
        </div>
	@else
		@if(empty($home_index) || is_null($home_index))
			<!-- <p>Tidak ada data yang ditemukan untuk pencarian "{{ $find }}"</p> -->
			<!-- <a href="/home/add">Silahkan klik disini jika ingin menambah data</a> -->
		@endif
	@endif
	<!-- session('news_url_id -->
    <br/>   
</body>
</html>