<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAGE TAMBAH DATA APA AJA BARU NIH</title>
</head>
<body>
<br>
	<h3>TAMBAH DATA URL BARU</h3>
 	<a href="javascript:history.back()">Kembali</a>	
	<br/>
	<br/>
	
	<form action="/cari/simpannewproduct" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		Tambah Produk Baru 
		<textarea name="nama" required="required" rows="3" cols="50">{{ old('find') }}</textarea> <br>
		<br>
		Deskripsi Produk 
		<textarea name="description" rows="5" cols="50">{{ session('metadata_description', '') }}</textarea><br>
		<br>
		Harga
		<textarea name="price" required="required" rows="1" cols="20"></textarea> <br/>
		<p>Upload gambar</p>
			<input type="file" name="image" accept="image/*">
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

</body>
</html>