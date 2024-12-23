<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/cekduluaja-kotak.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #007bff;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .sidebar h2 {
            text-align: center;
            margin: 20px 0;
            font-size: 1.5rem;
        }

        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu li {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .menu li:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .menu li a {
            text-decoration: none;
            color: white;
            display: block;
        }

        /* Content Area */
        .content {
            flex-grow: 1;
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
            overflow-y: auto; /* Aktifkan scroll vertikal */
        }

        .content.collapsed {
            margin-left: 0;
        }

        .content h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .toggle-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            z-index: 1001;
            transition: transform 0.3s ease-in-out;
        }

        .toggle-btn.collapsed {
            transform: translateX(250px);
        }

        .toggle-btn:hover {
            background-color: #0056b3;
        }

        /* Table Style */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            /* max-width: 60px; Membatasi ukuran kolom */
            /* overflow: hidden; Menghindari elemen membesar */
        }
        table th {
            background-color: #bcbcbc;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        table th:hover {
            background-color: #e2e2e2;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
         /* Gaya gambar thumbnail di tabel */
        .table-wrapper table img.thumbnail-img {
            width: 50px !important;   /* Ukuran kecil yang tegas */
            height: 50px !important;
            max-width: 50px;          /* Membatasi maksimum lebar */
            max-height: 50px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .table-wrapper table img.thumbnail-img:hover {
            transform: scale(1.1); /* Efek zoom saat hover */
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000; !important
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal-content {
            position: relative;
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            max-width: 80%;
            max-height: 80%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            overflow-y: auto; /* Menambahkan scroll vertikal */
            position: relative; /* Pastikan posisi relatif untuk tombol close */
        }

        .modal img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            color: #333;
            background: none;
            border: none;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close-btn:hover {
            color: #007bff;
        }



        .pagination {
            display: flex;
            justify-content: left;
            list-style-type: none;
            padding: 0;
            margin: 0;
            /* margin-top: 20px; */
        }

        .pagination li {
            margin: 0 5px; /* Jarak antar halaman */
        }

        .pagination li a {
            display: inline-block;
            padding: 8px 12px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination li a:hover {
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
        }

        .pagination li.active span {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            padding: 8px 12px;
            border: 1px solid #007bff;
        }

        .table-wrapper {
            max-height: calc(100vh - 100px); /* Sesuaikan tinggi maksimal berdasarkan tata letak halaman */
            overflow-y: auto; /* Aktifkan scroll vertikal jika konten melebihi tinggi */
            border: 1px solid #ddd; /* Tambahkan batas untuk area scroll */
            border-radius: 5px; /* Sudut melengkung untuk tampilan */
            margin-top: 20px;
        }

        .table-wrapper::-webkit-scrollbar {
            width: 8px; /* Lebar scrollbar */
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background-color: #007bff; /* Warna scrollbar */
            border-radius: 5px; /* Bentuk melengkung */
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background-color: #0056b3; /* Warna scrollbar saat hover */
        }


        /* //PUNYA USER */
        .user-profile-container {
        margin: 20px auto;
        padding: 20px;
        background-color: #fff !important; /* Pastikan warna box */
        border-radius: 10px;
        max-width: 800px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
        font-family: Arial, sans-serif;
    }

    .profile-details {
        background-color: white !important;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important; /* Tambahkan shadow */
        display: flex;
        gap: 15px;
    }

    .user-avatar {
        width: 150px !important; /* Atur ulang ukuran avatar */
        height: 150px !important;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd !important; /* Gunakan garis tegas */
    }

    .profile-info .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f4f4f4;
    }

    .profile-info .info-row:last-child {
        border-bottom: none;
    }

    .profile-info .info-label {
        font-weight: bold;
        color: #333;
    }

    .profile-info .info-value {
        color: #555;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f4f4f4;
       
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: bold;
        color: #333;
    }

    .info-value {
        color: #555;
    }


    .search-container {
        margin-bottom: 20px;
        text-align: right;

    }

    .search-container input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        width: 600px;
    }
    .avatar-container {
        margin-bottom: 20px;
        text-align: center;
    }

    .user-avatar {
        width: 300px;
        height: 300px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ddd;
    }
    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .user-table th, .user-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .user-table th {
        background-color: #f4f4f4;
        cursor: pointer;
    }

    .chart-container {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    #loadMoreButton {
        margin: 20px auto;
        padding: 10px 20px;
        display: block;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    #yearlyChartContainer {
        display: none;
    }
    </style>
     <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-ESM0Z1DLK4');
    </script>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2>Dashboard Menu</h2>
        <ul class="menu">
            <li><a href="#profile">Home</a></li>
            <li><a href="{{ route('dashboard.userprofile') }}">User Profile</a></li>
            <li><a href="{{ route('dashboard.users') }}">User List</a></li>
            <li><a href="{{ route('dashboard.news.comments') }}">URL Links</a></li>
            <li><a href="{{ route('dashboard.products') }}">Products List</a></li>
            <li><a href="{{ route('dashboard.feedback-detail') }}">Feedback Wall</a></li>
            <li><a href="{{ route('dashboard.news_chart') }}">News Chart</a></li>
            <li><a href="{{ route('dashboard.comment_chart') }}">Comment Chart</a></li>
            <li><a href="{{ route('dashboard.fourchart') }}">4 Chart</a></li>
            <li></li>
            <li><a href="/">Back Home</a></li>

        </ul>
    </div>

    <!-- Content -->
    <div class="content" id="content">
    
        <button class="toggle-btn" id="toggle-btn">☰ Menu</button>
        <!-- <h1>Welcome to the Dashboard</h1>
        <p>Choose a menu from the sidebar to see details.</p> -->
        @yield('content')
       
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const toggleBtn = document.getElementById('toggle-btn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            content.classList.toggle('collapsed');
            toggleBtn.classList.toggle('collapsed');
        });
    </script>
    @stack('scripts')
</body>
</html>
