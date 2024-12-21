<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - {{ $product->product_name }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/cekduluaja-kotak.png') }}">

    <style>
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
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .content-box {
            width: 100%; /* Sesuai dengan lebar container utama */
            background-color: #f7f7f7;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px 20px; /* Padding untuk membuat tinggi dinamis */
            margin-bottom: 20px;
            overflow-wrap: break-word; /* Menghindari teks yang terlalu panjang */
            box-sizing: border-box;
        }

        .content-box h3 {
            margin: 0 0 10px;
            font-size: 1.2rem;
            color: #444;
        }

        .content-box p {
            margin: 0;
            font-size: 1rem;
            color: #555;
            line-height: 1.5;
        }

        h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }

        p {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
        }

        .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin: 20px 0;
        }

        .description {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .slider-container {
            position: relative;
            max-width: 100%;
            margin: 20px auto;
            border-radius: 10px;
            overflow: hidden;
        }

        .slider-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            min-width: 100%;
            flex-shrink: 0;
        }

        .slider-images img {
            width: 100%;
            height: auto;
            display: block;
        }

        .slider-buttons {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .slider-buttons button {
            background: rgba(0, 0, 0, 0.5);
            border: none;
            color: white;
            font-size: 1.5rem;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 50%;
            transition: background 0.3s;
        }

        .slider-buttons button:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .slider-buttons button:focus {
            outline: none;
        }

        button {
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
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

        .qr-container {
            margin-top: 20px;
            display: none;
            flex-direction: column;
            align-items: center;
        }

        .qr-container img {
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        /* Container dengan garis keliling */
        .share-container {
            position: relative;
            border: 1px solid #ccc; /* Garis keliling abu tipis */
            border-radius: 10px; /* Sudut melengkung */
            padding: 20px;
            margin: 10px auto;
            width: 300px; /* Lebar kotak */
            text-align: center;
            background-color: #f9f9f9; /* Latar belakang kotak */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Bayangan halus */
        }

        /* Label di atas pojok kiri */
        .share-label {
            position: absolute;
            top: -10px;
            left: 15px;
            background-color: #f9f9f9; /* Warna latar belakang sama dengan kontainer */
            padding: 0 10px;
            font-size: 14px;
            color: #555;
            font-weight: bold;
        }

        /* Tombol Share */
        .share-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        /* Gaya gambar ikon */
        .share-buttons img {
            width: 40px;
            height: 40px;
            transition: transform 0.2s ease-in-out; /* Animasi hover */
            cursor: pointer;
        }

        .share-buttons img:hover {
            transform: scale(1.1); /* Sedikit perbesar saat hover */
        }

        /* Kontainer tombol Generate QR */
        .generate-qr-container {
            margin-top: 20px;
            text-align: center;
        }

        /* Tombol Generate QR */
        .btn-generate-qr {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-generate-qr:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-generate-qr img {
            width: 20px;
            height: 20px;
        }


    .user-info {
        position: absolute;
        top: 10px;
        right: 10px; /* Posisikan di pojok kanan atas */
        text-align: right; /* Teks rata kanan */
    }

    .logout-btn {
        background-color: #dc3545; /* Warna merah untuk logout */
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        margin-left: 10px;
    }

    .logout-btn:hover {
        background-color: #c82333;
    }

    </style>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
</head>
<body>

        
@if(session('success'))
    <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 15px; text-align: center;">
        {{ session('success') }}
    </div>
@endif
<br>
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
    <img src="{{ asset('img/cekduluajalogo.png') }}" alt="Logo" class="logo" style="width: 25%;"> <!-- Ubah path sesuai lokasi logo Anda -->
    <div style="margin-top: 20px;">
                <a href="javascript:history.back()">Kembali</a>	
                <a href="/showindexprod" class="btn-link">Daftar Promo</a>
    </div>
    <!-- Kotak untuk Deskripsi -->
    <div class="content-box">
        <!-- <h2>Deskripsi Produk</h2> -->
        <h2>{{ $product->product_name }}</h2>
    </div>  
     <!-- Menampilkan Deskripsi Produk dengan HTML -->
    <!-- Kotak untuk Deskripsi -->
    <div class="content-box">
        <h3>Deskripsi Produk</h3>
        <div>{!! $product->product_description !!}</div>
    </div>  
     <!-- <div class="description">
        {!! $product->product_description !!}
    </div> -->
    <!-- <p>{{ $product->product_description }}</p> -->
    <!-- <p class="price">Rp{{ number_format($product->product_price, 0, ',', '.') }}</p> -->
    <div class="content-box">
        <h3>Harga Produk</h3>
        <p>Rp{{ number_format($product->product_price, 0, ',', '.') }}</p>
    </div>
        <div class="content-box">
            <h3>Nomor Telepon</h3>
            <p>
                @if(!empty($product->product_contact_number))
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $product->product_contact_number) }}" target="_blank">
                        <img src="{{ asset('img/whatsapp icon.png') }}" alt="WhatsApp" style="width: 20px;"> WhatsApp
                    </a>
                    &nbsp; | &nbsp;
                    <a href="tel:{{ $product->product_contact_number }}">
                        <img src="{{ asset('img/call icon.png') }}" alt="Call" style="width: 20px;"> Call
                        : {{ $product->product_contact_number }}
                    </a>
                @else
                    Nomor telepon tidak tersedia.
                @endif
            </p>
            <br>
            Oleh: {{ $product->user ? $product->user->name : 'Tidak dikenal' }} 
            ( {{ \Carbon\Carbon::parse($product->created_at)->diffForHumans() }} ),
            Tgl : {{ \Carbon\Carbon::parse($product->created_at)->format('l, d M Y H:i') }}
            <br>
            Dilihat: {{ $product->product_viewed }}x
            Disukai : {{ $product->product_liked }}x
            <form action="{{ route('product.like', ['id' => $product->id]) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-liked">Like</button>
            </form>
            <!-- Tombol untuk menghasilkan QR Code
            <button onclick="generateQRCode()">Buat QR Code</button> -->
            @if(!empty($product->url))
                <div class="share-container">
                <span class="share-label">Bagikan ke...</span>
                    <div class="share-buttons" style="display: flex; gap: 10px; margin-top: 20px;">
                        <!-- Tombol Share ke Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($product->url) }}" 
                        target="_blank" 
                        style="text-decoration: none;">
                            <img src="{{ asset('img/facebook-icon.png') }}" alt="Facebook" style="width: 40px; height: 40px;">
                        </a>

                        <!-- Tombol Share ke Twitter -->
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($product->product_name) }}&url={{ urlencode($product->url) }}" 
                        target="_blank" 
                        style="text-decoration: none;">
                            <img src="{{ asset('img/twitter-icon.png') }}" alt="Twitter" style="width: 40px; height: 40px;">
                        </a>

                        <!-- Tombol Share ke WhatsApp -->
                        <a href="https://wa.me/?text={{ urlencode($product->product_name) }}%20{{ urlencode($product->url) }}" 
                        target="_blank" 
                        style="text-decoration: none;">
                            <img src="{{ asset('img/whatsapp-icon.png') }}" alt="WhatsApp" style="width: 40px; height: 40px;">
                        </a>

                        <!-- Tombol Share ke LinkedIn -->
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($product->url) }}&title={{ urlencode($product->product_name) }}" 
                        target="_blank" 
                        style="text-decoration: none;">
                            <img src="{{ asset('img/linkedin-icon.png') }}" alt="LinkedIn" style="width: 40px; height: 40px;">
                        </a>
                    </div> 
                </div>  
            @endif
            <!-- <button onclick="generateQRCode()">Buat QR Code</button> -->
                <div class="generate-qr-container" style="text-align: center; margin-top: 20px;">
                    <button class="btn-generate-qr" onclick="generateQRCode({{ $product->id }})">
                        <img src="{{ asset('img/qr code icon.png') }}" alt="Generate QR" style="width: 20px; height: 20px;">
                        Generate QR Code
                    </button>
                </div>
        </div>
    <div class="slider-container">
        <div class="slider-images" id="sliderImages">
            @foreach($product->getImages() as $image)
                <div class="slide">
                    <img src="{{ asset('storage/' . $image) }}" alt="Gambar Produk">
                </div>
            @endforeach
        </div>

        @if(count($product->getImages()) > 1)
            <div class="slider-buttons">
                <button onclick="moveSlider('prev')">❮</button>
                <button onclick="moveSlider('next')">❯</button>
            </div>
        @endif
        <!-- Kontainer untuk menampilkan QR Code -->
        <div class="qr-container" id="qrContainer">
            <p><strong>Scan QR Code untuk URL halaman produk ini:</strong></p>
            <!-- <img id="qrCode" alt="QR Code URL Halaman"> -->
            <button onclick="downloadPDF()">Unduh QR Code (PDF)</button>
        </div>

    </div>
</div>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('#sliderImages .slide');
    const totalSlides = slides.length;

    function moveSlider(direction) {
        if (direction === 'next') {
            currentSlide = (currentSlide + 1) % totalSlides;
        } else {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        }

        document.getElementById('sliderImages').style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    const productTitle = "{{ $product->product_name }}";
    const productUrl = "{{ $qrUrl }}"; // Mendapatkan URL dari controller
    const qrContainer = document.getElementById('qrContainer');
    const qrCodeElement = document.createElement('canvas'); // Ganti dengan elemen canvas untuk menambahkan logo
    const logoSrc = "{{ asset('img/cekduluaja-kotak.png') }}"; // Ganti dengan path logo Anda
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('source') === 'qr') {
        console.log("Halaman ini diakses melalui scan QR Code.");
    }


    function generateQRCode() {
            const productId = "{{ $product->id }}"; // ID Produk
            // Simpan URL ke database
            async function saveProductUrl() {
                try {
                    const response = await fetch("{{ route('product.save.url', $product->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}", // Sertakan CSRF token
                        },
                        body: JSON.stringify({ url: productUrl }),
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json();
                    alert("URL produk berhasil disimpan.");
                } catch (error) {
                    console.error("Terjadi kesalahan saat menyimpan URL:", error);
                    alert("Terjadi kesalahan saat menyimpan URL produk.");
                }
            }

            // Panggil fungsi untuk menyimpan URL
            saveProductUrl();

            // Kirim permintaan AJAX untuk increment QR count
            fetch(`{{ url('/increment-qr-count-generated') }}/${productId}`, { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}", // Sertakan CSRF token
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log(data.message); // Log pesan sukses dari server
            })
            .catch(error => {
                console.error("Error incrementing QR count:", error);
            });


        // Generate QR Code dengan logo di tengah
        QRCode.toCanvas(
            qrCodeElement,
            productUrl,
            // "{{ $qrUrl }}",
            {
                width: 300, // Ukuran QR Code
                margin: 2,  // Margin di sekitar QR
            },
            (err) => {
                if (err) {
                    console.error("QR Code generation error:", err);
                    return;
                }

                // Tambahkan logo ke QR Code setelah selesai render
                const context = qrCodeElement.getContext("2d");
                const logo = new Image();
                logo.src = logoSrc;

                logo.onload = () => {
                    const logoSize = qrCodeElement.width * 0.2; // Ukuran logo 20% dari QR Code
                    const x = (qrCodeElement.width - logoSize) / 2;
                    const y = (qrCodeElement.height - logoSize) / 2;

                    context.drawImage(logo, x, y, logoSize, logoSize);
                };

                qrContainer.style.display = 'flex'; // Tampilkan QR Code
                qrContainer.appendChild(qrCodeElement); // Tambahkan QR Code ke halaman
            }
        );
    }

    function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait', // Mengatur orientasi kertas
            unit: 'mm',              // Unit dalam milimeter
            format: 'a4',            // Ukuran kertas A4
        });

        // Mengatur ukuran halaman
        const pageWidth = doc.internal.pageSize.getWidth(); // Lebar halaman
        const pageHeight = doc.internal.pageSize.getHeight(); // Tinggi halaman
        // const qrCanvas = qrCodeContainer.querySelector('canvas');
        // const qrImage = qrCanvas.toDataURL('image/png');

        // Judul Produk
        doc.setFont("helvetica", "bold"); // Huruf tebal
        doc.setFontSize(18);
        doc.text(productTitle, pageWidth / 2, 20, { align: "center" }); // Center di atas halaman

        // **Mengatur ukuran gambar QR Code**
        const qrCodeData = qrCodeElement.toDataURL("image/png");
        const qrImageSize = Math.min(pageWidth - 20, pageHeight - 50); // Maksimalkan ukuran gambar dengan margin
        doc.addImage(qrCodeData, 'PNG', (pageWidth - qrImageSize) / 2, 40, qrImageSize, qrImageSize); // QR Code di tengah halaman

        // URL di bawah QR Code, rata kanan
        const urlTextY = 40 + qrImageSize + 10; // Posisi di bawah QR Code
        doc.setFont("helvetica", "normal");
        doc.setFontSize(12);
        doc.text("URL: " + productUrl, pageWidth - 10, urlTextY, { align: "right" });

        // Unduh PDF
        doc.save(`${productTitle.replace(/\s+/g, '_')}_QR_Code.pdf`);
    }
</script>


</body>
</html>
