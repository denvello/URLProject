<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        }

        .form-container h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #333;
        }

        /* Input Fields */
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
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
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

        /* Error Message */
        .error-message {
            color: red;
            margin-bottom: 15px;
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
        <!-- <img src="{{ asset('img/cekduluajalogo.png') }}" alt="Logo" class="logo" width=50%>  -->
        
        <h4>Login ADMINISTRATOR</h4>
        @if(session('message'))
            <div class="error-message">{{ session('message') }}</div>
        @endif
            @if(session('success'))
            <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
            @endif
            <br>

        <!-- Login Form -->
        <form method="POST" action="{{ route('admin.authenticate') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <!-- Navigation Links
        <p>Belum punya akun? 
            <a href="{{ route('register') }}">Daftar Sekarang</a>
        </p> -->
    </div>
</body>
</html>
