<div>
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
    box-shadow: 8px 0 25px rgba(0,0,0,0.25);
    backdrop-filter: blur(10px);
    padding-top: 22px;

    /* Textured background */
    background-image:
        radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
        radial-gradient(rgba(0,0,0,0.08) 1px, transparent 1px);
    background-size: 18px 18px, 22px 22px;

    /* ⭐ FIX UTAMA */
    z-index: 10000 !important;
}

.sidebar-title {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    color: #f8e4c2;
    letter-spacing: 2px;
    margin-bottom: 35px;
}

.sidebar a {
    display: block;
    padding: 14px 25px;
    color: #f5e4c7;
    text-decoration: none;
    font-size: 15px;
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
    margin-top: 80px;
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
    box-shadow: 0 5px 20px rgba(0,0,0,0.25);

    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 0 25px;

    z-index: 9000; /* ⭐ DI BAWAH SIDEBAR */
}

.navbar-custom .user-icon {
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

/* ================= FLOATING SEARCH BAR ================= */
.floating-search-wrapper {
    position: fixed;
    top: 78px;
    left: 260px;
    right: 20px;
    z-index: 5000; /* ⭐ masih di bawah sidebar */
    display: flex;
    justify-content: center;
    padding: 10px 0;
}

.floating-search-box {
    width: 55%;
    background: rgba(255, 255, 255, 0.65);
    backdrop-filter: blur(12px);
    transition: 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.4);
}

.floating-search-box:hover {
    background: rgba(255, 255, 255, 0.8);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.18);
}

/* content area */
.content-area {
    z-index: 1; /* ⭐ selalu di bawah sidebar */
}

.btn-vintage {
    background-color: #c49a6c;
    color: white;
    border: none;
}

.btn-vintage:hover {
    background-color: #a67c52;
}

/* ============ BURGER BUTTON ============ */
.burger-btn {
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 11000; /* ⭐ di atas sidebar */
    background: rgba(75, 50, 38, 0.95);
    padding: 10px 13px;
    border-radius: 8px;
    border: 1px solid rgba(255, 220, 180, 0.3);
    box-shadow: 0 3px 12px rgba(0,0,0,0.25);
    cursor: pointer;
}

.burger-btn i {
    font-size: 22px;
    color: #f8e4c2;
}

/* ============ MOBILE RESPONSIVE ============ */
@media (max-width: 992px) {

    .sidebar {
        left: -260px;
        transition: 0.3s ease;
        z-index: 10000 !important; /* ⭐ pastikan tetap paling atas */
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
    .modal-backdrop {
        z-index: 15000 !important;
    }

.modal {
    z-index: 16000 !important;
}
</style>

    <!-- HAMBURGER BUTTON -->
<div class="burger-btn d-lg-none" onclick="toggleSidebar()">
    <i class="fa fa-bars"></i>
</div>


       <!-- ================= NAVBAR ================= -->
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

    <!-- ================= SIDEBAR ================= -->
    <div class="sidebar">
        <div class="sidebar-title">KOSanKU</div>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa fa-home me-2"></i> Dashboard
        </a>

        <a href="{{ route('admin.rooms') }}" class="{{ request()->routeIs('admin.rooms') ? 'active' : '' }}">
            <i class="fa fa-door-open me-2"></i> Room
        </a>

        <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.index') ? 'active' : '' }}">
            <i class="fa fa-calendar-check me-2"></i> Booking
        </a>

        <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.index') ? 'active' : '' }}">
            <i class="fa fa-money-bill me-2"></i> Payment
        </a>

        <a href="{{ route('admin.favorites.index') }}" class="{{ request()->routeIs('admin.favorites.index') ? 'active' : '' }}">
            <i class="fa fa-heart me-2"></i> Favorite
        </a>
    </div>
    
<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('sidebar-open');
}
</script>

</div>


 

