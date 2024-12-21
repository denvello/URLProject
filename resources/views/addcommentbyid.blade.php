<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAGE TAMBAH DATA KOMEN BARU NIH</title>
</head>
<body>
<br>
	<h3>TAMBAH KOMEN BARU</h3>
	<a href="javascript:history.back()">Kembali</a>	
	<br/>
	<br/>
    <form action="/cari/simpankomen" method="post">
    {{ csrf_field() }}
    <!-- Tambahkan kolom hidden untuk menyimpan kata kunci pencarian  -->
    <input type="hidden" name="search_keyword" value="{{ session('search_keyword', '') }} ">
    <!-- //Menggunakan id dari session -->
    <input type="hidden" name="id" value="{{ session('news_url_id') }}">
   
    <label for="comment_text">Komentar anda</label><br/>
    <textarea id="comment_text" name="comment_text" rows="10" cols="50" required="required" 
              oninput="checkWordLimit(this, 200)" placeholder="Masukkan komentar Anda...">{{ session('input_comment', '') }}</textarea>
    
    <p id="wordCountMessage"></p>

    <input type="submit" value="Simpan Data">
</form>

<script>
// Fungsi untuk membatasi jumlah kata
function checkWordLimit(textarea, maxWords) {
    let words = textarea.value.trim().split(/\s+/); // Menghitung jumlah kata
    let wordCount = words.length;
    
    if (wordCount > maxWords) {
        // Jika kata lebih dari 200, potong kata-kata yang lebih
        textarea.value = words.slice(0, maxWords).join(" ");
        wordCount = maxWords;
        message.innerHTML = `Batas maksimum ${maxWords} kata tercapai.`;
    }
    
    // Tampilkan pesan sisa kata
    let message = `Sisa kata yang dapat diinput: ${maxWords - wordCount}`;
    document.getElementById("wordCountMessage").innerText = message;
}
</script>

<!-- Debug Session (hanya untuk keperluan testing) -->
@if(session('search_keyword'))
        <p>Session Keyword: {{ session('search_keyword') }}</p>
        <p>Session ID: {{ session('news_url_id') }}</p>
    @else
        <p>Session Keyword tidak ditemukan di view search.</p>
    @endif
</body>
</html>