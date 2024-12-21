<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Komentar Baru [cekduluaja.com]</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/cekduluaja-kotak.png') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 1rem;
            color: #555;
            margin-bottom: 5px;
        }

        textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button, input[type="submit"] {
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover, input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .word-count {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 10px;
        }

        .preview-container {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .image-preview {
        width: 100px;
        height: 100px;
        border: 1px dashed #ccc;
        border-radius: 5px;
        overflow: hidden;
        position: relative; /* Penting: Untuk posisi absolut tombol Remove */
        background-color: #f7f7f7;
    }

    .image-preview img {
        width: 100%; /* Gambar memenuhi container */
        height: 100%; /* Gambar memenuhi container */
        object-fit: cover; /* Gambar menyesuaikan dengan aspek rasio */
    }

    .remove-btn {
        position: absolute; /* Posisi tombol relatif ke .image-preview */
        top: 5px; /* Jarak dari atas gambar */
        right: 5px; /* Jarak dari kanan gambar */
        background-color: red;
        color: white;
        border: none;
        border-radius: 50% !important;
        width: 20px !important; /* Ukuran lebih kecil */
        height: 20px !important; /* Ukuran lebih kecil */
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        z-index: 10; /* Pastikan tombol berada di atas gambar */
        font-size: 10px; /* Font lebih kecil */
        font-weight: bold;

       
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Sedikit bayangan */
        transition: background-color 0.3s, transform 0.2s; /* Efek hover */
    }

    .remove-btn:hover {
        background-color: darkred;
        transform: scale(1.1); /* Sedikit perbesar saat hover */
    }

        button, input[type="submit"] {
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .error-messages {
            color: red;
            margin-bottom: 20px;
        }
    
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
        <img src="{{ asset('img/cekduluajalogo.png') }}" alt="Logo" class="logo" style="width: 25%;">
    </div>
    <h3>Tambah Komentar Baru</h3>
    <h4>Hasil pencarian : {{ session('search_keyword') }}</h4>

    <a href="javascript:history.back()">Kembali</a>

    <form action="/simpankomen" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Hidden Inputs -->
        <input type="hidden" name="search_keyword" value="{{ session('search_keyword', '') }}">
        <input type="hidden" name="id" value="{{ session('news_url_id') }}">
        <input type="hidden" name="url_slug" value="{{ session('url_slug') }}">

        <!-- Input Komentar -->
        <label for="comment_text">Komentar Anda</label>
        <textarea id="comment_text" name="comment_text" rows="10" required 
          oninput="checkWordLimit(this, 500)" placeholder="Masukkan komentar Anda...">{{ old('comment_text', session('input_comment', '')) }}</textarea>
        <div class="word-count" id="wordCountMessage"></div>

        <!-- Upload Gambar -->
        <label for="imagekomen">Upload Gambar di Komentar</label>
        <input type="file" id="imagekomen" name="imagekomen" accept="image/*" onchange="previewImage(event)">

        <div class="preview-container" id="previewContainer" style="display: none;">
            <div class="image-preview" id="imagePreview">
                <button type="button" class="remove-btn" onclick="removeImage()">X</button>
            </div>
        </div>
        <!-- Submit -->
        <input type="submit" value="Simpan Data">
    </form>

    <!-- Pesan Error -->
    @if($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Debugging Session -->
    <!-- <p>Session Keyword: {{ session('search_keyword') }}</p>
    <p>Session ID: {{ session('news_url_id') }}</p>

    @if(session('search_keyword'))
        <p>Session Keyword di IF: {{ session('search_keyword') }}</p>
        <p>Session ID di IF: {{ session('news_url_id') }}</p>
    @else
        <p>Session Keyword tidak ditemukan di view search.</p>
    @endif -->
</div>

<script>
    function checkWordLimit(textarea, maxWords) {
        let words = textarea.value.trim().split(/\s+/).filter(function(word) {
            return word.length > 0; // Menghapus spasi kosong
        });
        let wordCount = words.length;
        let messageElement = document.getElementById("wordCountMessage");

        if (wordCount > maxWords) {
            textarea.value = words.slice(0, maxWords).join(" ");
            wordCount = maxWords;
            messageElement.innerHTML = `Batas maksimum ${maxWords} kata tercapai.`;
        } else {
            messageElement.innerHTML = `Sisa kata yang dapat diinput: ${maxWords - wordCount}`;
        }
    }

    function previewImage(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const maxSize = 100 * 1024; // 100KB

        if (file) {
            if (!file.type.startsWith("image/")) {
                alert("File harus berupa gambar!");
                event.target.value = "";
                return;
            }

            if (file.size > maxSize) {
                alert("Gambar tidak boleh lebih dari 100KB.");
                event.target.value = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.style.display = "flex";
                imagePreview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-btn" onclick="removeImage()">X</button>
                `;
            };
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        const previewContainer = document.getElementById('previewContainer');
        const imageInput = document.getElementById('imagekomen');
        const imagePreview = document.getElementById('imagePreview');

        previewContainer.style.display = "none";
        imageInput.value = ""; // Reset input file
        imagePreview.innerHTML = ""; // Hapus pratinjau
    }
</script>

</body>
</html>
