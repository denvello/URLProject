<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Feedback</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/cekduluaja-kotak.png') }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 1rem;
            color: #555;
        }

        input[type="text"],
        textarea,
        select {
            width: 95%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 0.9rem;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Feedback</h1>
        @if ($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf
            <div>
                <label for="title">Judul Feedback:</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div>
                <label for="category">Kategori:</label>
                <br>
                <select id="category" name="category" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="UI/UX" {{ old('category') == 'UI/UX' ? 'selected' : '' }}>UI/UX</option>
                    <option value="Bug" {{ old('category') == 'Bug' ? 'selected' : '' }}>Bug</option>
                    <option value="Fitur Baru" {{ old('category') == 'Fitur Baru' ? 'selected' : '' }}>Fitur Baru</option>
                    <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div>
                <label for="description">Deskripsi:</label>
                <textarea id="description" name="description" required>{{ old('description') }}</textarea>
            </div>
            <button type="submit">Kirim Feedback</button>
        </form>
        <a href="{{ route('feedback.index') }}" class="back-link">Kembali ke Wall of Feedback</a>
    </div>
</body>
</html>
