<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wall of Feedback</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/cekduluaja-kotak.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        /* Feedback Cards */
        .feedback-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .feedback-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feedback-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            padding: 15px;
            background: #5b5b5b;
            color: #fff;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .card-body {
            padding: 15px;
            font-size: 0.95rem;
            color: #555;
            text-align: justify; /* Justify text */
        }

        .card-footer {
            padding: 10px 15px;
            background: #f5f5f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .vote-buttons {
            display: flex;
            gap: 10px;
        }

        .vote-buttons button {
            display: flex;
            align-items: center;
            gap: 5px;
            border: none;
            background: #f0f0f0;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 0.9rem;
            color: #333;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .vote-buttons button:hover {
            background: #e0e0e0;
        }

        .vote-buttons .upvote {
            color: blue;
        }

        .vote-buttons .downvote {
            color: red;
        }


        .pagination {
            display: flex;
            justify-content: left;
            list-style-type: none;
            padding: 0;
            margin: 0;
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

        .user-info {
            position: absolute;
            top: 10px;
            right: 10px; /* Posisikan di pojok kanan atas */
            text-align: right; /* Teks rata kanan */
        }
         /* Sesuaikan ukuran logo */
         .logo {
            max-width: 300px;
            margin-bottom: 10px;
        }
        .btn-link {
        display: inline-block;
        background-color: #999999;
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        font-size: 1rem;
        border-radius: 5px;
        margin: 5px;
        transition: background-color 0.3s;
        }

        .btn-link:hover {
            background-color: #5b5b5b;
            text-decoration: none;
        }

        /* Modal Background */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    /* Modal Content */
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 10px;
        width: 60%;
        max-height: 70vh;
        overflow-y: auto;
        animation: slideIn 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        
    }

    /* Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    /* Animation */
    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Scrollable Content */
    .full-description {
        max-height: 60vh;
        overflow-y: auto;
        line-height: 1.6;
        color: #333;
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
    <div class="container" style="position: relative;">
        <div class="user-info">
            
            @if(Auth::check() && Auth::user()->name)
                <!-- <span>Hi, {{ Auth::user()->name }}!</span> -->
                <span style="display: flex; gap: 5px; align-items: center;">
                    Hi,
                    <a href="{{ route('profile.show', Auth::user()->id) }}" style="text-decoration: none; color: inherit;">
                        {{ Auth::user()->name }}
                    </a>
                    <a href="{{ route('info.landing') }}" style="text-decoration: none; color: inherit;">
                       [?] 
                    </a>  
                </span>
                <form action="{{ route('logout') }}" method="GET" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            @else 
                <span style="display: flex; gap: 10px; align-items: center;">
                    <a href="{{ route('login') }}" style="text-decoration: none; color: inherit;">
                        <h4>...</h4>
                    </a> 
                    <a href="{{ route('info.landing') }}" style="text-decoration: none; color: inherit;">
                        <h4>[?]</h4>
                    </a>                            
                </span>
            @endif
        </div>
          <!-- Menampilkan logo -->
        <img src="{{ asset('img/cekduluajalogo.png') }}" alt="Logo" class="logo"> <!-- Ubah path sesuai lokasi logo Anda -->
        <h1>Wall of Feedback</h1>
        <div style="margin-top: 20px;">
            <a href="/" class="btn-link">Home</a>
            <a href="/feedback/create" class="btn-link">Tambah Saran</a>    
        </div>
        @if(session('success'))
            <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
            @endif
        <br>    
        <!-- Feedback Cards -->
        <div class="feedback-grid">
            @forelse($feedbacks as $feedback)
                <div class="feedback-card" onclick="handleCardClick({{ $feedback->id }})">
                    <div class="card-header">
                        {{ $feedback->title }}
                    </div>
                    <div class="card-body">
                        {{ Str::limit($feedback->description, 200) }}
                    </div>
                    <div class="card-footer">
                        <span>
                            {{ $feedback->user->name ?? 'Anonymous' }} • {{ $feedback->created_at->diffForHumans() }}
                        </span>
                        <!-- <div class="vote-buttons">
                            <button class="upvote" 
                                onclick="{{ Auth::check() ? 'voteFeedback(' . $feedback->id . ', \'up\')' : 'redirectToLogin()' }}">
                                <i class="fas fa-thumbs-up"></i> {{ $feedback->upvotes }}
                            </button>
                            <button class="downvote" 
                                onclick="{{ Auth::check() ? 'voteFeedback(' . $feedback->id . ', \'down\')' : 'redirectToLogin()' }}">
                                <i class="fas fa-thumbs-down"></i> {{ $feedback->downvotes }}
                            </button>
                        </div> -->
                        <div>
                            👍 {{ $feedback->upvotes }} | 👎 {{ $feedback->downvotes }}
                        </div>
                    </div>
                </div>
            <!-- Modal for Description -->
            <div id="modal-{{ $feedback->id }}" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal({{ $feedback->id }})">&times;</span>
                    <h2>{{ $feedback->title }}</h2>
                    <div contenteditable="true" id="description" style="text-align: justify; border: 1px solid #ccc; padding: 10px; border-radius: 5px; min-height: 150px;">
                        <p class="full-description">
                            {{ $feedback->description }}
                        </p>
                    </div> 
                    <!-- <div style="margin-top: 20px; text-align: center;">
                        <button class="upvote" onclick="{{ Auth::check() ? 'voteFeedback(' . $feedback->id . ', \'up\')' : 'redirectToLogin()' }}">
                            <i class="fas fa-thumbs-up"></i> Upvote
                        </button>
                        <button class="downvote" onclick="{{ Auth::check() ? 'voteFeedback(' . $feedback->id . ', \'down\')' : 'redirectToLogin()' }}">
                            <i class="fas fa-thumbs-down"></i> Downvote
                        </button>
                    </div>    -->
                    <div class="vote-buttons">
                            <button class="upvote" 
                                onclick="{{ Auth::check() ? 'voteFeedback(' . $feedback->id . ', \'up\')' : 'redirectToLogin()' }}">
                                <i class="fas fa-thumbs-up"></i> {{ $feedback->upvotes }}
                            </button>
                            <button class="downvote" 
                                onclick="{{ Auth::check() ? 'voteFeedback(' . $feedback->id . ', \'down\')' : 'redirectToLogin()' }}">
                                <i class="fas fa-thumbs-down"></i> {{ $feedback->downvotes }}
                            </button>
                        </div>
                </div>
            </div>
  
            @empty
                <p class="text-center">Belum ada feedback. Jadilah yang pertama memberikan masukan!</p>
            @endforelse
        </div>
        <br>
        <!-- Pagination -->
        <div class="pagination">
            {{ $feedbacks->links() }}
        </div>
    </div>

    <script>
        function redirectToLogin() {
            alert("Anda harus login untuk memberikan suara.");
            window.location.href = '/login';
        }

        async function voteFeedback(feedbackId, type) {
            console.log(`Voting for feedback ID: ${feedbackId}, Type: ${type}`);
            // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                 const response = await fetch(`/feedback/${feedbackId}/vote`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        // 'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ type }),
                });

                if (response.status === 401) {
                    redirectToLogin();
                    return;
                }

                const result = await response.json();
                console.log('Vote success:', result); 
                alert(result.message);
                location.reload(); // Refresh page to update vote counts
            } catch (error) {
                console.error('Error voting:', error);
            }
        }
    </script>

    <script>
        function handleCardClick(feedbackId) {
            const modal = document.getElementById(`modal-${feedbackId}`);
            if (modal) {
                modal.style.display = 'block';
            }
        }

        function closeModal(feedbackId) {
            const modal = document.getElementById(`modal-${feedbackId}`);
            if (modal) {
                modal.style.display = 'none';
            }
        }

        // Close the modal when clicking outside
        window.onclick = function (event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        };
    </script>
</body>
</html>
