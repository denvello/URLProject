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
	<!-- <a href="/home/cari"> Cari URL</a>	
	<br/>
	<br/> -->
	<a href="javascript:history.back()">Kembali</a>	
	<br/>
	<br/>
	<form action="/home/simpannewurl" method="post">
	{{ csrf_field() }}
		Alamat URL Baru :<input type="text" name="url" required="required"> <br/>
		Judul URL :<input type="text" name="title" required="required"> <br/>	
		<input type="submit" value="Simpan Data">
		
		
	</form>
</body>
</html>