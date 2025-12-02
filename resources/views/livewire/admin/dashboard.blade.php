<div class="container py-4">

    {{-- =======================
        STATISTIC CARDS (Warna sudah benar dan konsisten)
    ======================== --}}
    <div class="row g-4 mb-4">

        {{-- Total Rooms (Primary - BIRU) --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="text-secondary text-uppercase small mb-1">Total Rooms</p>
                        <h3 class="text-primary">{{ $roomsCount }}</h3> 
                    </div>
                    <div class="text-primary opacity-50">
                        <i class="fa fa-building fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Bookings (Info - BIRU MUDA) --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="text-secondary text-uppercase small mb-1">Total Bookings</p>
                        <h3 class="text-info">{{ $bookingsCount }}</h3>
                    </div>
                    <div class="text-info opacity-50">
                        <i class="fa fa-calendar-check fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Payments (Success - HIJAU) --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="text-secondary text-uppercase small mb-1">Total Payments</p>
                        <h3 class="text-success">{{ $paymentsCount }}</h3>
                    </div>
                    <div class="text-success opacity-50">
                        <i class="fa fa-money-bill fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Favorites (Danger - MERAH) --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="text-secondary text-uppercase small mb-1">Total Favorites</p>
                        <h3 class="text-danger">{{ $favoritesCount }}</h3>
                    </div>
                    <div class="text-danger opacity-50">
                        <i class="fa fa-heart fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- =======================
        STACKED BAR CHART
    ======================== --}}
    <div class="card shadow-sm border-0 p-4">
        <h5 class="fw-bold mb-3">Income Overview</h5>
        
        <canvas id="stackedChart" height="160"></canvas>
    </div>

</div>


{{-- =======================
        CHART.JS SCRIPT
======================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("livewire:init", () => {

    let ctx = document.getElementById("stackedChart");

    let chart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: @json($chartLabels),

            datasets: [
                {
                    label: "Total Rooms", 
                    data: @json($totalRooms), 
                    // Warna Rooms: Primary (Biru) -> rgba(0, 123, 255, 0.5)
                    backgroundColor: "rgba(0, 123, 255, 0.5)" 
                },
                {
                    label: "Total Bookings",
                    data: @json($totalBookings), 
                    // Warna Bookings: Info (Biru Muda) -> rgba(23, 162, 184, 0.7)
                    backgroundColor: "rgba(23, 162, 184, 0.7)" 
                },
                {
                    label: "Total Payments",
                    data: @json($totalPayments), 
                    // Warna Payments: Success (Hijau) -> rgba(40, 167, 69, 0.8)
                    backgroundColor: "rgba(40, 167, 69, 0.8)" 
                },
                {
                    label: "Total Favorites",
                    data: @json($totalFavorites), 
                    // Warna Favorites: Danger (Merah) -> rgba(220, 53, 69, 0.6)
                    backgroundColor: "rgba(220, 53, 69, 0.6)" 
                }
            ]
        },

        options: {
            responsive: true,
            plugins: {
                legend: { position: "bottom" }
            },
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true }
            }
        }
    });

});
</script>