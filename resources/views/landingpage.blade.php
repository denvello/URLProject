<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page with Scroll Animations</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

         /* Intro Section Styles */
         .intro-section {
            position: relative;
            width: 100%;
            height: auto;
            overflow: hidden;
        }

        .intro-section img {
            width: 100%;
            height: auto;
            opacity: 0; /* Initially hidden */
            transform: scale(1.1); /* Slight zoom effect */
            transition: opacity 1s ease-out, transform 1s ease-out;
        }

        .intro-section img.visible {
            opacity: 1; /* Fade-in effect */
            transform: scale(1); /* Reset scale for smooth zoom-in */
        }


        .section {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 50px;
            min-height: 100vh;
            position: relative;
            opacity: 0; /* Initially hidden */
            transform: translateY(50px); /* Slide-in effect */
            transition: all 0.8s ease-in-out;
        }

        .section.visible {
            opacity: 1; /* Fully visible when active */
            transform: translateY(0); /* Return to original position */
        }

        .section:nth-child(odd) {
            background-color: #ffffff;
        }

        .section:nth-child(even) {
            background-color: #f1f1f1;
        }

        .container {
            flex: 1;
            padding: 20px;
            text-align: justify;
        }

        h1, h2, h3 {
            color: #c0392b;
            margin: 0 0 20px 0;
        }

        p {
            margin: 10px 0;
        }

        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            max-width: 90%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }


        /* Style for the full-width image */
        .full-width-image {
            display: block; /* Ensures it's a block-level element */
            width: 100%;    /* Stretches to the full width of the viewport */
            height: auto;   /* Maintains the aspect ratio */
        }


    /* Carousel Container */
    .carousel-container {
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    /* Carousel Track */
    .carousel-track {
        display: flex;
        width: calc(10% * 6); /* Adjust for 6 images */
        animation: scroll-carousel 10s linear infinite;
    } 

    /* Carousel Images */
    .carousel-track img {
        width: 100%;
        flex-shrink: 0;
        object-fit: cover;
    }
 
    /* Animation */
    @keyframes scroll-carousel {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-100%);
        }
    } 

    /* Styling the container */
    .image-row-container {
        display: flex;                /* Align items horizontally */
        justify-content: space-between; /* Evenly space out the images */
        align-items: center;          /* Align items vertically at the center */
        width: 90%;                   /* Set width to 90% of the page */
        margin: 0 auto;               /* Center the container horizontally */
        padding: 10px;                /* Add some padding for spacing */
        box-sizing: border-box;       /* Include padding in width calculations */
    }

    /* Styling the images */
    .image-item {
        width: calc(33.33% - 10px);   /* Ensure three images fit within the container */
        height: auto;                 /* Maintain aspect ratio */
        border-radius: 5px;           /* Optional: add rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: add a shadow effect */
    }

    /* Adjust the gap between images */
    .image-item:not(:last-child) {
        margin-right: 10px;           /* Add spacing between images */
    }

    /* Center the button container */
    .button-container {
        text-align: center;
        margin-top: 20px;
    }

    /* Button styling */
    .custom-button {
        display: inline-block;
        width: 300px;
        padding: 15px 0;
        background-color: #b0b0b0; /* Default gray color */
        color: white;
        text-align: center;
        text-decoration: none; /* Remove underline */
        font-size: 16px;
        border-radius: 5px; /* Rounded corners */
        transition: all 0.3s ease; /* Smooth transition for hover effects */
        cursor: pointer;
    }

    /* Hover effect */
    .custom-button:hover {
        background-color: #888888; /* Darker gray on hover */
        transform: scale(1.05); /* Slightly increase size */
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
<img src="img/intro01.png" alt="Intro Image 1" class="full-width-image">
<img src="img/intro02.png" alt="Intro Image 2" class="full-width-image">
   
   
<!-- Sections WELCOME -->    
    <div class="section" id="home">
        <div class="container">
            <h1>Selamat bergabung di cekduluaja.com</h1>
            <p> {{ $projectText }}</p>
            <br>
            <p> {{ $projectText2 }}</p>
        </div>
        <div class="image-container">
            <img src="img/hero.png" alt="Hero Image">
        </div>
    </div>

     <!-- Sections CARANYA -->
     <div class="section" id="caranya">
        <div class="image-container">
            <img src="img/caranya.png" alt="How to Image">
        </div>
        <div class="container">
            <h1>Caranya gimana?</h1>
            <p> {{ $caraText }}</p>
            <br>
            <p> {{ $caraText2 }}</p>
        </div>
    </div>

    <!-- Carousel Container -->
    <div class="carousel-container">
        <div class="carousel-track">
            <img src="img/cekok.png" alt="Image 1">
            <img src="img/cekno.png" alt="Image 2">
            <img src="img/cekwarning.png" alt="Image 3">
            <!-- Cloned Images for Loop -->
            <img src="img/cekok.png" alt="Image 1 Clone">
            <img src="img/cekno.png" alt="Image 2 Clone">
            <img src="img/cekwarning.png" alt="Image 3 Clone">
        </div>
    </div> 


    <div class="section" id="about">
        <div class="container">
            <h2>About Us</h2>
            <p>{{ $aboutText }}</p>
           
        </div>
        <div class="image-container">
            <img src="img/aboutus.png" alt="About Us">
        </div>
    </div>

     <!-- Sections SERVICES -->
    <div class="section" id="services">
        <div class="image-container">
            <img src="img/ourservice.png" alt="Services">
        </div>
        <div class="container">
            <h2>Our Services</h2>
            <ul>
                <li>Cek URL : misal lowongan kerja, sosmed, berita, perusahaan, apapun yg ada URL bisa dicek, dll</li>
                <li>Cek Judul : bisa cari keyword tertentu, misal no telp, nama orang, nama perusahaan, berita hoax, dll</li>
                <li>QR Code Promo : jual / sewa barang / jasa (Gratis)</li>
            </ul>
        </div>
    </div>

    <div class="button-container">
        <a href="{{ route('home') }}" class="custom-button"> Masuk & lanjutkan </a>
    </div>

    <script>
        // Use Intersection Observer for animations
        const sections = document.querySelectorAll('.section');

        const observerOptions = {
            threshold: 0.2, // Trigger when 20% of the section is visible
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible'); // Add visible class
                    observer.unobserve(entry.target); // Stop observing once it's visible
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            observer.observe(section); // Observe each section
        });
    </script>

</body>
</html>
