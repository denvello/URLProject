<!DOCTYPE html>
<html>
<head>
	<title>Tutorial Membuat CRUD Pada Laravel</title>
</head>
<body>
    <style type="text/css">
		.pagination li{
			float: left;
			list-style-type: none;
			margin:5px;
		}
	</style>
	<h2>www.malasngoding.com</h2>
	<h3>Data News URL</h3>
	
   
	<p>Cari Data URL :</p>
    <a href="/home">Home</a>
    <br>
    <br>
	<form action="/home/find" method="GET">
		<input type="text" name="find" placeholder="Cari URL .." value="{{ old('find') }}" style="width: 600px;">
		<input type="submit" value="TOMBOL FIND">
	</form>
	
		@if($errors->has('find'))
		<div class="alert alert-danger" style="color: red;">
			{{ $errors->first('find') }}
			<a href="/home/add">Klik Disini untuk Tambah Data?</a>
		</div>
		@endif
		<br/>
		<br/>

	<!-- Menampilkan Data Hanya Jika Ada Hasil Pencarian -->
	@if(!empty($news_url) && count($news_url) > 0)
		<table border="1">
			<tr>
				<th>ID</th>
				<th>URL</th>
				<th>TITLE</th>
				<th>CREATED AT</th>
			
			</tr>
		
				@foreach($news_url as $p)
				<tr>
					<td>{{ $p->id }}</td>
					<td>{{ $p->url }}</td>
					<td>{{ $p->title }}</td>
					<td>{{ $p->created_at }}</td>
					<td>
						<a href="/news_url/edit/{{ $p->id }}">Edit</a>
						|
						<a href="/news_url/hapus/{{ $p->id }}">Hapus</a>
					</td>
				</tr>
				@endforeach
		
		</table>
	
	@else
		@if(empty($news_url) || is_null($news_url))
			<p>Tidak ada data yang ditemukan untuk pencarian "{{ $find }}"</p>
			<a href="/home/add">Silahkan klik disini jika ingin menambah data</a>
		@endif



	@endif
    <br/>
</body>
</html>