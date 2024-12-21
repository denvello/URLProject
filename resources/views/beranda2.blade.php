<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <!-- <h1>Selamat datang,</h1> -->
    <h1>Selamat datang, {{ Auth::user()->name ?? ''}}!</h1>
    <!-- Menampilkan token dari cookie -->
    <p>Token Anda: {{ $_COOKIE['user_token'] ?? 'Token tidak ditemukan' }}</p>

    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="GET">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <!-- Login Button -->
    <form action="{{ route('home') }}" method="GET">
        @csrf
        <button type="submit">HOME</button>
    </form>
</body>
</html>