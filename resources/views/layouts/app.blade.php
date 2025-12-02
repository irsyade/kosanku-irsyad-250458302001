<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOSanKU | Dashboard User</title>

    <!-- Fonts & Plugins -->
     <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @livewireStyles

    <style>
        body {
            font-family: 'Poppins';
            background-color: #f4e7d2;
            overflow-x: hidden;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: rgba(75, 50, 38, 0.92);
            border-right: 2px solid rgba(255, 220, 180, 0.2);
            box-shadow: 8px 0 25px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            padding-top: 22px;
            z-index: 4000 !important;

            background-image:
                radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                radial-gradient(rgba(0, 0, 0, 0.08) 1px, transparent 1px);
            background-size: 18px 18px, 22px 22px;
        }

        .sidebar-title h4 {
            text-align: center;
            color: #f8e4c2;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            padding: 14px 25px;
            color: #f5e4c7;
            font-size: 15px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: rgba(200, 160, 110, 0.25);
            padding-left: 35px;
        }

        .sidebar a.active {
            background: linear-gradient(to right, #caa074, #9c6b4a);
            color: #fff;
            font-weight: 700;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.3);
        }

        /* Untuk layout user: geser konten agar tidak numpuk dengan sidebar */
.content-area {
    margin-left: 280px; /* ukuran sama dengan sidebar */
    margin-right: 20px;
    transition: margin .3s ease;
}

@media (max-width: 768px) {
    .content-area {
        margin-left: 0; /* mobile otomatis full */
    }
}

        /* ================= NAVBAR ================= */
        .navbar-custom {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            height: 70px;
            background: rgba(75, 50, 38, 0.92);
            border-bottom: 2px solid rgba(255, 220, 180, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.25);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 25px;
            z-index: 4000;
        }

        .user-icon {
            font-size: 22px;
            margin-right: 10px;
            color: #fff;
        }

        .navbar-custom .nav-link {
            color: #fff;
            font-weight: bold;
        }

        .navbar-custom .nav-link:hover {
            color: #e8c99a;
        }

        /* ================= SEARCH FLOATING ================= */
        .floating-search-wrapper {
            position: fixed;
            top: 85px;
            left: 260px;
            right: 20px;
            z-index: 3500;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }

        .floating-search-box {
            width: 55%;
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: 0.3s;
        }

        .floating-search-box:hover {
            background: rgba(255, 255, 255, 0.85);
            box-shadow: 0 8px 25px rgba(0,0,0,0.18);
            transform: translateY(-2px);
        }

        .btn-vintage {
            background-color: #c49a6c;
            color: white;
            border: none;
        }

        .btn-vintage:hover {
            background-color: #a67c52;
        }

        /* ================= CONTENT ================= */
        .content-area {
            z-index: 1;
        }

        /* ================= HAMBURGER ================= */
        .burger-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            padding: 10px 13px;
            background: rgba(75, 50, 38, 0.95);
            border-radius: 8px;
            border: 1px solid rgba(255, 220, 180, 0.3);
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.25);
            z-index: 11000;
            cursor: pointer;
        }

        .burger-btn i {
            font-size: 22px;
            color: #f8e4c2;
        }

        /* ================= MODAL FIX ================= */
        .modal-backdrop.show {
            z-index: 11000 !important;
            background-color: rgba(0,0,0,0.55) !important;
            position: fixed !important;
        }

        .modal.show {
            z-index: 12000 !important;
        }

        .modal-dialog {
            z-index: 13000 !important;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 992px) {

            .sidebar {
                left: -260px;
                transition: 0.3s;
            }

            .sidebar.sidebar-open {
                left: 0;
            }

            .navbar-custom {
                left: 0 !important;
            }

            .floating-search-wrapper {
                left: 0 !important;
            }

           
        }
    </style>
</head>

<body>

    <!-- HAMBURGER -->
    <div class="burger-btn d-lg-none" onclick="toggleSidebar()">
        <i class="fa fa-bars"></i>
        
    </div>

    <!-- NAVBAR -->
    <nav class="navbar-custom">
        @auth
        <i class="fa fa-circle-user user-icon"></i>
        <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-sm">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                </form>
            </div>
        </div>
        @endauth
    </nav>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="/" class="sidebar-title text-decoration-none">
            <h4>KOSanKU</h4>
        </a>

        <a href="{{ route('rooms') }}" class="{{ request()->routeIs('rooms') ? 'active' : '' }}">
            <i class="fa fa-door-open me-2"></i> Daftar Kamar
        </a>

        <a href="{{ route('bookings') }}" class="{{ request()->routeIs('bookings') ? 'active' : '' }}">
            <i class="fa fa-calendar-check me-2"></i> Booking Saya
        </a>

        <a href="{{ route('favorites') }}" class="{{ request()->routeIs('favorites') ? 'active' : '' }}">
            <i class="fa fa-heart me-2"></i> Favorit
        </a>

        <a href="{{ route('payments') }}" class="{{ request()->routeIs('payments') ? 'active' : '' }}">
            <i class="fa fa-money-bill me-2"></i> Pembayaran
        </a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="content-area">
        {{ $slot }}
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('sidebar-open');
        }
    </script>

    @livewireScripts
    @stack('scripts')

</body>
</html>
