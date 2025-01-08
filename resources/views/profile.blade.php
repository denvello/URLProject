<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        /* Similar to register/login CSS */
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

        .form-container {
            background-color: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .form-container h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #333;
        }

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
        }

        .form-container input:focus {
            border-color: #007bff;
            outline: none;
        }

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

        .preview-container {
            margin-bottom: 20px;
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin: 10px auto;
            border: 2px solid #ccc;
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }

         /* Button Container */
         .button-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 15px;
        }

        .button-group a {
            flex: 1;
            text-align: center;
            padding: 12px 15px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .button-group a:hover {
            background-color: #0056b3;
            transform: scale(1.02);
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
        <h1>User Profile</h1>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            <!-- Avatar -->
            <div class="preview-container">
                <div class="avatar-preview">
                    <!-- <img src="{{ $user->user_avatar ? asset('storage/' . $user->user_avatar) : asset('img/default-avatar.png') }}" alt="Avatar"> -->
                    <img src="{{ $user->user_avatar ?: asset('img/default-avatar.png') }}" alt="Avatar">

                </div>
                <p>Joined: {{ $user->created_at->format('d M Y') }}</p>
                <label for="avatar">Change Avatar:</label>
                <input type="file" name="avatar" id="avatar" accept="image/*">
            </div>

            <!-- Name -->
            <input type="text" name="name" value="{{ $user->name }}" placeholder="Name" required>
            
            <!-- Email -->
            <input type="email" name="email" value="{{ $user->email }}" placeholder="Email" required>
            
            <!-- Password -->
            <input type="password" name="password" placeholder="New Password (optional)">
            <input type="password" name="password_confirmation" placeholder="Confirm New Password (optional)">

            <button type="submit">Update Profile</button>
        </form>
        <div class="button-group">
            <a href="{{ route('caridulu') }}">Ke Halaman Utama</a>
            <a href="{{ route('admin.login') }}">Ke Halaman Dashboard User</a>
            <a href="{{ route('feedback.index') }}">Ke Halaman Feedback</a>
        </div>
    </div>
</body>
</html>
