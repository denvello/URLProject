<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk AKTIF</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-size: 1rem;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        .image-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .image-container div {
            width: 100px;
            height: 100px;
            object-fit: cover;
            position: relative;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f0f0f0;
            overflow: hidden;
        }
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
            cursor: pointer;
        }
        .remove-btn:hover {
            background-color: darkred;
        }
        button {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 0.9rem;
            margin-top: -10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Tambah Produk Baru AKTIF</h2>
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="product_name">Nama Produk</label>
            <input type="text" id="product_name" name="product_name" placeholder="Masukkan nama produk" required>
            <div class="error" id="error_product_name"></div>
        </div>

        <div>
            <label for="product_description">Deskripsi Produk</label>
            <textarea id="product_description" name="product_description" placeholder="Masukkan deskripsi produk"></textarea>
            <div class="error" id="error_product_description"></div>
        </div>

        <div>
            <label for="product_price">Harga Produk</label>
            <input type="number" id="product_price" name="product_price" placeholder="Masukkan harga produk" required>
            <div class="error" id="error_product_price"></div>
        </div>

        <div>
            <label for="product_images">Upload Gambar Produk (maks. 5 gambar)</label>
            <input type="file" id="product_images" name="product_images[]" accept="image/*" multiple>
            <div class="image-container" id="image_container"></div>
            <div class="error" id="error_product_images"></div>
        </div>

        <button type="submit">Tambah Produk</button>
    </form>    
</div>

<script>
    const form = document.querySelector('form');
    const imageContainer = document.getElementById('image_container');
    const imageInput = document.getElementById('product_images');
    let imageFiles = []; // Array untuk menyimpan file

    // Handle image upload dan preview
    imageInput.addEventListener('change', handleImageUpload);

    function handleImageUpload(event) {
        const files = Array.from(event.target.files);

        if (imageFiles.length + files.length > 5) {
            alert("Anda hanya dapat meng-upload hingga 5 gambar.");
            return;
        }

        files.forEach((file) => {
            if (imageFiles.some(existingFile => existingFile.file.name === file.name)) {
                alert(`File "${file.name}" sudah diunggah.`);
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imageFiles.push({
                    file: file,
                    dataUrl: e.target.result
                });

                renderImagePreviews(); // Render ulang preview
                updateInputFiles();    // Update elemen input file
            };

            reader.readAsDataURL(file);
        });
    }

    function removeImage(index) {
        imageFiles.splice(index, 1); // Hapus file dari array
        renderImagePreviews();       // Render ulang preview
        updateInputFiles();          // Update elemen input file
    }

    function renderImagePreviews() {
        imageContainer.innerHTML = ''; // Kosongkan preview container

        imageFiles.forEach((imageData, index) => {
            const imageDiv = document.createElement('div');
            const imgElement = document.createElement('img');
            const removeBtn = document.createElement('button');

            imgElement.src = imageData.dataUrl; // Gunakan data URL yang sudah disimpan
            removeBtn.className = 'remove-btn';
            removeBtn.innerHTML = 'X';
            removeBtn.onclick = () => removeImage(index); // Hapus berdasarkan index

            imageDiv.appendChild(imgElement);
            imageDiv.appendChild(removeBtn);
            imageContainer.appendChild(imageDiv);
        });
    }

    function updateInputFiles() {
        const dataTransfer = new DataTransfer(); // Membuat objek DataTransfer baru
        imageFiles.forEach(image => dataTransfer.items.add(image.file)); // Tambahkan file ke DataTransfer
        imageInput.files = dataTransfer.files; // Update elemen input file
    }

    form.addEventListener('submit', (event) => {
        if (imageFiles.length > 5) {
            event.preventDefault();
            alert("Anda hanya dapat mengunggah hingga 5 gambar.");
        }
        updateInputFiles(); // Pastikan elemen input diperbarui sebelum submit
    });
</script>

</body>
</html>
