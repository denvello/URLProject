<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data URL Baru [cekduluaja.com]</title>
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

        .image-preview {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            height: 200px;
            border: 1px dashed #ccc;
            border-radius: 5px;
            overflow: hidden;
            background-color: #f7f7f7;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
        }

        .error-messages {
            color: red;
            margin-bottom: 20px;
        }

        .input-container p {
        word-wrap: break-word; /* Ensure long text wraps to the next line */
        white-space: pre-wrap; /* Preserve spaces and line breaks */
        background-color: #f7f7f7;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        font-size: 1rem;
        color: #333;
        box-sizing: border-box; /* Include padding in width */
    }

    .input-container input[type="hidden"] {
        display: none; /* Hide the hidden input field */
    }

    </style>
</head>
<body>

	<div class="container">
		<h3>Tambah Data URL Baru</h3>
		<a href="javascript:history.back()">Kembali</a>	
		<br/>
		<form action="/simpannewurlbaru" method="POST" enctype="multipart/form-data">
			@csrf

			<!-- Input URL -->
			<!-- <label for="find">Tambah URL Baru</label> -->
			<div class="input-container">
                <label for="find">Tambah URL Baru</label>
                <p id="find-display">{{ old('find', session('search_keyword', '')) }}</p>
                <input type="hidden" name="find" id="find" value="{{ old('find', session('search_keyword', '')) }}">
            </div>
            <!-- <p>{{ old('find', session('search_keyword', '')) }}</p> -->
            <!-- Input hidden untuk menyimpan nilai -->
            <input type="hidden" name="find" id="find" value="{{ old('find', session('search_keyword', '')) }}">

			<!-- Input Judul
			<label for="title">Tambah Judul URL</label>
            <textarea name="title" id="title" rows="3" required maxlength="500" 
            pattern="^[^<>]*$/?" 
            title="Karakter HTML tidak diperbolehkan">{{ session('metadata_title', '') }}</textarea> -->
            <label for="title">Tambah Judul URL</label>

            <textarea 
                name="title" 
                id="title" 
                rows="3" 
                required 
                maxlength="500" 
                title="Hanya huruf, angka, dan tanda baca '.' yang diperbolehkan"
            >{{ session('metadata_title', '') }}</textarea>
            <p id="error-message" style="color: red; display: none;">Karakter tidak valid telah dihapus.</p>
            <script>
                document.getElementById('title').addEventListener('input', function () {
                    const invalidCharacters = /[^a-zA-Z0-9. ]/g; // Pola untuk karakter tidak valid
                    const originalValue = this.value;

                    // Bersihkan karakter yang tidak diinginkan
                    const sanitizedValue = originalValue.replace(invalidCharacters, ' ');

                    if (originalValue !== sanitizedValue) {
                        // Tampilkan pesan bahwa karakter dihapus
                        document.getElementById('error-message').style.display = 'block';
                    } else {
                        // Sembunyikan pesan jika input sudah valid
                        document.getElementById('error-message').style.display = 'none';
                    }

                    // Perbarui nilai input
                    this.value = sanitizedValue;
                });
            </script>
			<!-- Gambar Metadata -->
			<label for="image">Gambar Metadata</label>
			@if(session('metadata_image'))
				<div class="image-preview" id="imagePreview">
					<img src="{{ session('metadata_image') }}" alt="Metadata Image" id="imagePreviewImage">
				</div>
			@endif
			<input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">

			<!-- Deskripsi Metadata -->
			<label for="description">Deskripsi Metadata</label>
			<textarea name="description" id="description" rows="5">{{ session('metadata_description', '') . ' | Author: ' . session('metadata_author', '') }}</textarea>
            @error('description')
                <div style="color: red;">{{ $message }}</div>
            @enderror    
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
    
	</div>

	<script>
		function previewImage(event) {
			const file = event.target.files[0];
			const previewContainer = document.getElementById('imagePreview');
			const previewImage = document.getElementById('imagePreviewImage');

			if (file) {
				const reader = new FileReader();
				reader.onload = function (e) {
					if (!previewImage) {
						const newImage = document.createElement('img');
						newImage.id = 'imagePreviewImage';
						previewContainer.appendChild(newImage);
					}
					previewImage.src = e.target.result;
				};
				reader.readAsDataURL(file);
			}
		}
	</script>

</body>
</html>