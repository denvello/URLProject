<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <style type="text/css">
		    .pagination li{
			float: left;
			list-style-type: none;
			margin:5px;
		}
	    </style>
        
        <h3>Data News URL</h3>
        <p>Cari Data URL :</p>
        <a href="/home/cari">Home</a>
        <br>
        <br>
    <form action="cari" method="GET">
		<br>
        <br>
        <input type="text" name="find" placeholder="Cari URL .." value="{{ old('find') }}" style="width: 600px;">
		<input type="submit" value="TOMBOL CARI">
	</form>

    <br/>
	<br/>

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
                
            </tr>
            @endforeach
       
	</table>
    <br/>

</body>
</html>