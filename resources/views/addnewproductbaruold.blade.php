<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
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
    <h2>Tambah Produk Baru</h2>
    
    
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

            <!-- <div>
                <label for="url">URL Produk</label>
                <input type="text" id="url" name="url" placeholder="Masukkan URL produk" required>
                <div class="error" id="error_url"></div>
            </div> -->

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
    const imageContainer = document.getElementById('image_container');
    const imageInput = document.getElementById('product_images');
    //const form = document.getElementById('productForm');
    
    let imageFiles = [];

    // Handle image upload and preview
    imageInput.addEventListener('change', handleImageUpload);

    function handleImageUpload(event) {
        const files = Array.from(event.target.files);
        
        // Ensure maximum 5 images
        if (imageFiles.length + files.length > 5) {
            alert("Anda hanya dapat meng-upload hingga 5 gambar.");
            return;
        }

        files.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Add image to the preview array
                imageFiles.push({
                    src: e.target.result,
                    file: file,
                    index: imageFiles.length + index // to handle removal correctly
                });

                renderImagePreviews();
            };

            reader.readAsDataURL(file);
        });
    }

    function renderImagePreviews() {
        imageContainer.innerHTML = ''; // Clear current previews

        imageFiles.forEach((image, index) => {
            const imageDiv = document.createElement('div');
            const imgElement = document.createElement('img');
            const removeBtn = document.createElement('button');

            imgElement.src = image.src;
            removeBtn.className = 'remove-btn';
            removeBtn.innerHTML = 'X';
            removeBtn.onclick = () => removeImage(index);

            imageDiv.appendChild(imgElement);
            imageDiv.appendChild(removeBtn);
            imageContainer.appendChild(imageDiv);
        });
    }

    function removeImage(index) {
        // Remove image from the files array
        imageFiles.splice(index, 1);
        renderImagePreviews();
    }

    // Handle form submission
    document.getElementById('productForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting

        // Clear previous errors
        document.querySelectorAll('.error').forEach(function(error) {
            error.textContent = '';
        });

        // Form validation
        let valid = true;
        const productName = document.getElementById('product_name').value.trim();
        const productDescription = document.getElementById('product_description').value.trim();
        const productPrice = document.getElementById('product_price').value.trim();
        //const url = document.getElementById('url').value.trim();

        if (!productName) {
            valid = false;
            document.getElementById('error_product_name').textContent = "Nama produk tidak boleh kosong.";
        }
        if (!productPrice || isNaN(productPrice)) {
            valid = false;
            document.getElementById('error_product_price').textContent = "Harga produk harus berupa angka.";
        }
        if (!url) {
            valid = false;
            document.getElementById('error_url').textContent = "URL produk tidak boleh kosong.";
        }
        if (imageFiles.length === 0) {
            valid = false;
            document.getElementById('error_product_images').textContent = "Anda harus meng-upload setidaknya satu gambar produk.";
        }

        //If valid, submit the form
        if (valid) {
            const formData = new FormData(this);

            // Append all image files to form data
            imageFiles.forEach(image => formData.append('product_images[]', image.file));

            // For demonstration purposes, print data to the console
            console.log("Form Data: ", formData);

            //Here you can use Fetch or AJAX to send formData to the server
            alert("Produk berhasil ditambahkan!");

            //Reset form
            document.getElementById('productForm').reset();
            imageFiles = []; // Reset image files array
            renderImagePreviews(); // Reset image previews
            //document.getElementById('productForm').addEventListener('submit', function(event)) {
   
        }
    });
</script>

</body>
</html>
