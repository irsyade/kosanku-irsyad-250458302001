<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KOSanKU | Penginapan Nyaman Bergaya Vintage</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJ/AHgW9F02xKkX5V8f+6C7u4A/5B21r2b+F73Kj7K/v1T/m/s/A/A/A/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="overflow-x-hidden">

    <div class="burger-btn md:hidden" onclick="toggleMobileMenu()">
        <i class="bi bi-list"></i>
    </div>
    
    <header class="backdrop-blur-xl bg-[#6a4e47]/80 shadow-[0_8px_25px_rgba(0,0,0,0.25)] text-white fixed top-0 left-0 w-full z-50
                 border-b border-[#e8c7a1]/20 transition-all duration-300">

        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">

            <h1 class="text-3xl font-extrabold tracking-widest drop-shadow-[0_3px_3px_rgba(0,0,0,0.6)] text-[#f8e4c2]">
                KOSan<span class="text-[#d4b48c]">KU</span>
            </h1>

            <nav id="menu" class="hidden md:flex items-center space-x-10 text-lg">
                <a class="lux-link" href="#about">Tentang</a>
                <a class="lux-link" href="#gallery">Galeri</a>
                <a class="lux-link" href="#testimoni">Testimoni</a>
                <a class="lux-link" href="#contact">Kontak</a>
                

                @auth
                    @if(auth()->user()->role === 'user')
                    <span class="text-[#ffe139d8] font-medium">Halo, {{ auth()->user()->name }}</span>
                        <a href="{{ route('home') }}"
                           class="px-5 py-2 bg-gradient-to-br from-[#c9a074] to-[#a67c52] 
                                  text-white rounded-xl shadow-lg font-semibold hover:scale-105
                                  transition-all duration-300">
                            Dashboard
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button
                              class="px-5 py-2 bg-gradient-to-br from-red-600 to-red-700 
                                     rounded-xl shadow-md font-semibold hover:scale-105 
                                     transition-all duration-300">
                                Keluar
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-2 bg-gradient-to-br from-[#d4b48c] to-[#b08b63]
                              rounded-xl shadow-lg font-bold text-white hover:scale-105
                              transition-all duration-300">
                        Login
                    </a>
                @endauth
            </nav>
        </div>

        <div id="mobile-menu"
             class="hidden md:hidden flex-col space-y-4 px-6 py-5 bg-[#5a3f39]/95 
                    border-t border-[#c6a78a]/20">

            <a class="lux-link block" href="#about">Tentang</a>
            <a class="lux-link block" href="#gallery">Galeri</a>
            <a class="lux-link block" href="#testimoni">Testimoni</a>
            <a class="lux-link block" href="#contact">Kontak</a>

            <br>
            <br>

            @auth
                @if(auth()->user()->role === 'user')
                    

                    <form href="{{ route('home') }}"
                       class="px-6 py-2 bg-gradient-to-br from-[#c9a074] to-[#a67c52] 
                                  text-white rounded-lg mt-2 shadow-md font-semibold hover:scale-105
                                  transition-all duration-300 text-center">
                        Dashboard
                    </form>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="w-full bg-red-600 text-white font-semibold px-6 py-2 rounded-lg mt-2 shadow-md">
                            Keluar
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="w-full px-6 py-2 bg-gradient-to-br from-[#d4b48c] to-[#a67c52]
                          text-white text-center rounded-lg shadow-md">
                    Login
                </a>
            @endauth
        </div>
    </header>

    <style>
        html, body {
    margin: 0;
    padding: 0;
}

body {
    min-height: 100vh;
    background-color: #f6ebd5; /* contoh */
}


        .lux-link {
            position: relative;
            font-weight: 500;
            transition: all .3s ease;
        }
        .lux-link::after {
            content: "";
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -5px;
            left: 0;
            background: #f8e4c2;
            transition: 0.3s;
            border-radius: 10px;
        }
        .lux-link:hover {
            color: #f8e4c2;
        }
        .lux-link:hover::after {
            width: 100%;
        }

        /* ============ BURGER BUTTON ============ */
        .burger-btn {
            /* ⭐ Perbaikan posisi agar tidak terlalu mepet kiri */
            position: fixed;
            top: 20px;
            right: 20px; /* Pindahkan ke kanan atas seperti navbar pada umumnya */
            left: auto; /* Hapus left: 15px */
            z-index: 9999; /* Z-index tinggi */
            background: rgba(75, 50, 38, 0.95);
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid rgba(255, 220, 180, 0.3);
            box-shadow: 0 3px 12px rgba(0,0,0,0.25);
            cursor: pointer;
        }

        .burger-btn i {
            font-size: 24px;
            color: #f8e4c2;
        }
    </style>

    <script>
        // ⭐ PERBAIKAN 3: Ganti nama fungsi, targetkan #mobile-menu, dan gunakan class 'hidden'
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            // Menghilangkan atau menambahkan class 'hidden' untuk menampilkan/menyembunyikan menu
            mobileMenu.classList.toggle('hidden');
        }
    </script>

    <main class="container-fluid mt-4">
        @yield('content')
    </main>
</body>
</html>