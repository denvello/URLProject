<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <style>
        /* Styling untuk Hover Trigger */
        .hover-container {
            position: relative;
            display: inline-block;
        }

        /* Styling untuk Pop-up Form Password */
        .password-popup {
            display: none;
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 250px;
            padding: 20px;
            background-color: #f8d7da;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            text-align: center;
        }

        /* Styling untuk form */
        .password-popup form {
            display: flex;
            flex-direction: column;
        }

        .password-popup input {
            margin-bottom: 10px;
            padding: 8px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .password-popup button {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Hover effect */
        .hover-container:hover .password-popup {
            display: block;
        }
    </style>
</head>
<body>

<!-- Bagian Utama -->
<div class="hover-container">
    <a href="#">Klik Disini untuk Masukkan Password</a>

    <!-- Form Password yang akan tampil saat hover -->
    <div class="password-popup">
        <form action="{{ route('verify_password') }}" method="post">
            @csrf
            <label for="password">Masukkan Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Verifikasi</button>
        </form>
    </div>
</div>

</body>
</html>
