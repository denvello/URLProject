<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Container Styling */
        .form-container {
            background-color: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin: 50px auto;

            /* /width: 800px;
            margin: 50px auto;
            /padding: 20px 30px;
            /background-color: white;
            /border-radius: 10px;
            /box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
        }

        .form-container h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #333;
        }

        /* Input Fields */
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-container input:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Submit Button */
        .form-container button {
            width: 100%;
            padding: 12px 15px;
            /* //margin-top: 10px; */
            /* background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px; */
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .form-container button:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }

        /* Additional Styling */
        .form-container p {
            font-size: 0.9rem;
            color: #666;
            margin-top: 15px;
        }

        .form-container a {
            color: #007bff;
            text-decoration: none;
        }

        .form-container a:hover {
            text-decoration: underline;
        }

        .preview-container {
        display: flex;
        align-items: center;
        margin-top: 20px;
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
        position: absolute; /* Posisi relatif ke .image-preview */
        top: 5px; /* Jarak dari atas */
        right: 5px; /* Jarak dari kanan */
        background-color: red !important;/* Warna merah */
        color: white; /* Teks putih */
        border: none;
        border-radius: 50% !important; /* Membuat bentuk bulat */
        width: 20px !important; /* Lebar tombol */
        height: 20px !important; /* Tinggi tombol */
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        z-index: 10; /* Pastikan tombol berada di atas elemen lain */
        font-size: 12px; /* Ukuran font lebih kecil */
        font-weight: bold; /* Teks tebal */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Sedikit bayangan */
        transition: background-color 0.3s, transform 0.2s; /* Efek hover */
    }

    .remove-btn:hover {
        background-color: darkred; /* Warna merah tua saat hover */
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

        /* Upload Profile Picture Container */
.upload-container {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 15px;
    margin: 15px 0;
    text-align: left;
    background-color: #f7f7f7;
    /* width: 100%; */
}

.upload-container label {
    font-size: 0.9rem;
    color: #333;
    margin-bottom: 10px;
    display: block;
}

.upload-container input[type="file"] {
    width: 90%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 10px;
    font-size: 0.9rem;
}

    </style>
     <!-- Google tag (gtag.js) -->
     <script async src="https://www.googletagmanager.com/gtag/js?id=G-ESM0Z1DLK4"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-ESM0Z1DLK4');
    </script>
</head>
<body>
    <div class="form-container">
         <!-- Menampilkan logo -->
         <img src="{{ asset('img/cekduluajalogo.png') }}" alt="Logo" class="logo" width=50%> 
        
        <h1>Register</h1>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <!-- Profile Picture Container -->
            <div class="upload-container">
                <label for="avatar">Upload Profile Picture:</label>
                <input type="file" name="avatar" id="avatar" accept="image/webp,image/png,image/jpeg,image/gif" onchange="previewImage(event)">
            </div>
            
            <!-- Image Preview -->
            <div class="preview-container" id="previewContainer" style="display: none;">
                <div class="image-preview" id="imagePreview">
                    <button type="button" class="remove-btn" onclick="removeImage()">X</button>
                </div>
            </div> 
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>

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
        <!-- </div> -->
    </div>
    <script>    
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
            const imageInput = document.getElementById('avatar');
            const imagePreview = document.getElementById('imagePreview');

            previewContainer.style.display = "none";
            imageInput.value = ""; // Reset input file
            imagePreview.innerHTML = ""; // Hapus pratinjau
        }
    </script>
</body>
</html>
