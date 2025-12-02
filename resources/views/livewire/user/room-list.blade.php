<div class="rooms-component">
        <!-- SEARCH FLOATING -->
    <div class="floating-search-wrapper">
        <div class="input-group floating-search-box rounded-pill shadow-lg">
            <input 
    wire:model.live.debounce.300ms="search"
    type="text"
    class="form-control border-0 ps-4 py-2"
    placeholder="Cari nama atau alamat kamar...">

            <button wire:click="searchRooms" class="btn btn-vintage px-4">
                <i class="fa fa-search me-1"></i> Cari
            </button>
        </div>
    </div>

    <!-- GRID LIST -->
    <div class="container py-4">
        <div class="row g-4">

            @forelse ($rooms as $room)
                <div class="col-md-4 col-sm-6">
                    <div class="card room-card border-0 shadow-lg rounded-4 overflow-hidden h-100">
                        <img src="{{ $room->image_url }}" class="room-img" alt="{{ $room->name }}">

                        <div class="card-body text-center">
                            <h5 class="fw-bold text-vintage-dark">{{ $room->name }}</h5>
                            <p class="text-muted small mb-2">
                                <i class="fa fa-map-marker-alt me-1"></i>
                                {{ $room->address }}
                            </p>

                            <button
                                wire:click="openDetail({{ $room->id }})"
                                class="btn btn-vintage rounded-pill px-4 btn-press">
                                <i class="fa fa-eye me-1"></i> Detail
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fa fa-bed fa-3x mb-3"></i>
                    <p>Kamar tidak ditemukan.</p>
                </div>
            @endforelse

        </div>

        <!-- PAGINATION -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $rooms->links() }}
        </div>
    </div>


 @include('user.room-detail')

    <!-- POPUP ALERT -->
    <div id="popupAlert" class="custom-popup">
        <span id="popupMessage"></span>
    </div>


    <!-- ====== COMPONENT STYLES (CLEAN & RESPONSIVE) ====== -->
    <style>
        /* ROOM CARDS */
        .room-card { transition: transform .18s ease, box-shadow .18s ease; }
        .room-card:hover { transform: translateY(-6px); box-shadow: 0 14px 30px rgba(0,0,0,0.12); }

        .room-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        @media (max-width: 576px) {
            .room-img { height: 180px; }
        }

        /* BUTTON PRESS EFFECT */
        .btn-press:active { transform: scale(0.94); }

        /* MODAL IMAGE */
        .modal-room-img {
            max-height: 320px;
            width: 100%;
            object-fit: cover;
        }

        @media (max-width: 576px) {
            .modal-room-img { max-height: 220px; }
            .modal-dialog { margin: 1.2rem; }
        }

        /* RESPONSIVE MODAL FOR MOBILE */
        @media (max-width: 992px) {
            .modal-dialog {
                width: 95vw;
                margin: 1rem auto;
                max-width: none;
            }
            .modal-body {
                max-height: 70vh;
                overflow-y: auto;
            }
        }

        /* POPUP ALERT */
        .custom-popup {
            position: fixed;
            bottom: -80px;
            right: 30px;
            background: #2f2f2f;
            color: #fff;
            padding: 12px 16px;
            border-radius: 12px;
            box-shadow: 0 6px 22px rgba(0,0,0,0.28);
            font-size: 14px;
            opacity: 0;
            transition: transform .32s ease, opacity .32s ease, bottom .32s ease;
            z-index: 14000;
        }
        .custom-popup.show { bottom: 30px; opacity: 1; transform: translateY(0); }

        /* UTILITY: ensure container inside content-area doesn't overflow sidebar */
        .container.py-4 { max-width: 1100px; }

        /* small accessibility tweak for modal title */
        .modal-header .modal-title { font-size: 1.05rem; }

        body{
            padding-top: 160px;
        }
    </style>


    <!-- ====== COMPONENT SCRIPTS ====== -->
    <script>
        function showPopup(message) {
            const popup = document.getElementById('popupAlert');
            const text = document.getElementById('popupMessage');
            text.textContent = message;
            popup.classList.add('show');
            setTimeout(() => popup.classList.remove('show'), 2000);
        }

        // optional: allow ESC key to close Livewire modal (calls server action)
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                // if modal shown, call Livewire method to close (safe-guard)
                if (@json($showDetailModal)) {
                    // trigger Livewire closeDetailModal if available
                    try { Livewire.emit('closeDetailModal'); } catch (err) { /* ignore */ }
                }
            }
        });
    </script>
</div>
