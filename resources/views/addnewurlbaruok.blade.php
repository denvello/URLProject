<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAGE TAMBAH DATA URL BARU NIH</title>
</head>
<body>
<br>
	<h3>TAMBAH DATA URL BARU</h3>
 
	<!-- <a href="/cari"> Cari URL</a> -->
	<a href="javascript:history.back()">Kembali</a>	
	<br/>
	<br/>
	
	

	<form action="/simpannewurlbaru" method="post" enctype="multipart/form-data">
	<!-- <form action="/cari/simpannewurlbaru" method="post"> -->
		
		{{ csrf_field() }}
		<!-- Silahkan tambah alamat URL baru <input type="text" name="url" required="required"> <br/> -->
		<!-- Tambah URL baru <input type="text" name="find" required="required"> <br/>
		Judul URL <input type="text" name="title" required="required"> <br/> -->

		<!-- Tambah URL Baru <textarea name="find" required="required" rows="3" cols="50"></textarea> <br/>
		Tambah Judul URL <textarea name="title" required="required" rows="3" cols="50"></textarea> <br/> -->
		
		Tambah URL Baru 
		<textarea name="find" required="required" rows="3" cols="50">{{ old('find', session('search_keyword', '')) }}</textarea> <br>
		
		Tambah Judul URL 
		<textarea name="title" required="required" rows="3" cols="50">{{ session('metadata_title', '') }}</textarea> <br/>
		
		
		@if(session('metadata_image'))
		<p>Gambar Metadata</p>
			<img src="{{ session('metadata_image') }}" alt="Metadata Image" style="max-width: 200px; margin-top: 10px;">
		@else
			<p>Upload gambar</p>
			<input type="file" name="image" accept="image/*">

		@endif
		<br>
		Deskripsi metadata 
		<textarea name="description" rows="5" cols="50">{{ session('metadata_description', '') }}</textarea><br>
		<input type="submit" value="Simpan Data nih">
	</form>
	
	<br>
		@if($errors->any())
		<div style="color: red; margin-bottom: 10px;">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
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