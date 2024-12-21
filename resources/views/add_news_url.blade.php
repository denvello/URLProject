<!DOCTYPE html>
<html>
<head>
	<title>Tutorial Membuat CRUD Pada Laravel - www.malasngoding.com</title>
</head>
<body>
 
	<br>
	<h3>TAMBAH DATA URL BARU</h3>
 
	<a href="/home"> Kembali</a>
	
	<br/>
	<br/>
 
	<form action="/home/store" method="post">
		{{ csrf_field() }}
		URL <input type="text" name="url" required="required"> <br/>
		Judul URL <input type="text" name="title" required="required"> <br/>
		
		<input type="submit" value="Simpan Data">
	</form>
 
</body>
</html>