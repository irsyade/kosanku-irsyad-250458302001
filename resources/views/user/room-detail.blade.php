{{-- ===============================
        MODAL DETAIL (PREMIUM STYLE)
================================ --}}
@if($showDetailModal)

    {{-- BACKDROP --}}
    <div class="modal-backdrop show" style="background: rgba(0,0,0,0.35); backdrop-filter: 
    blur(3px);"></div>

    {{-- MODAL --}}
    <div class="modal fade show d-block" role="dialog" aria-modal="true" style="z-index:12000;">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down" 
        role="document">
            <div class="modal-content border-0 rounded-4 shadow-lg"
                style="background: linear-gradient(135deg, #ffffff, #faf7f2);">

                {{-- HEADER --}}
                <div class="modal-header rounded-top-4"
                    style="background: linear-gradient(135deg, #5c3d2e); color:#ffff;">
                    <h5 class="modal-title fw-bold">
                        Detail Kamar: {{ $detailRoom['name'] ?? '-' }}
                    </h5>
                    <button type="button" wire:click="closeDetailModal" class="btn-close"></button>
                </div>

                {{-- BODY --}}
                <div class="modal-body p-4">

                    <div class="row g-4">

                       {{-- INFO --}}
        <div class="col-lg-6 col-md-6">

            <div class="p-3 rounded-4 shadow-sm"
                style="background: #ffffffd9; backdrop-filter: blur(3px); border: 1px solid #eee;">
                
                <p><strong>Nama Kamar:</strong> {{ $detailRoom['name'] ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $detailRoom['address'] ?? '-' }}</p>

                <p><strong>Harga:</strong>
                    Rp {{ number_format($detailRoom['price'] ?? 0, 0, ',', '.') }}
                </p>

                {{-- ✅ PERUBAHAN 1: Menampilkan Sisa Kapasitas (available_capacity) --}}
                <p>
                    <strong>Kapasitas Tersisa:</strong>
                    {{ $detailRoom['available_capacity'] ?? $detailRoom['capacity'] }} Orang
                </p>

                {{-- ✅ PERUBAHAN 2: Menampilkan Status Dinamis (status_ketersediaan) --}}
                <p>
                    <strong>Status Ketersediaan:</strong>
                      {{-- STATUS MANUAL ADMIN --}}
                        @php
                            $status = $detailRoom['status'] ?? 'unknown';

                            switch ($status) {
                                case 'active':
                                    $label = 'Tersedia';
                                    $badgeClass = 'bg-success';
                                    break;

                                case 'penuh':
                                    $label = 'Penuh';
                                    $badgeClass = 'bg-danger';
                                    break;

                                case 'inactive':
                                    $label = 'Tidak Aktif';
                                    $badgeClass = 'bg-secondary';
                                    break;

                                default:
                                    $label = 'Tidak Diketahui';
                                    $badgeClass = 'bg-dark';
                            }
                        @endphp
                        <p>
                            <strong>Status:</strong>
                            <span class="badge {{ $badgeClass }} px-3 py-2">
                                {{ $label }}
                            </span>
                        </p>     
            </div>
        </div>

                        {{-- IMAGE --}}
                        <div class="col-lg-6 col-md-6 text-center">
                            <div>
                                <img src="{{ $detailRoom['image_url'] ?? '/no-image.png' }}"
                                    class="img-fluid rounded-4 shadow-sm"
                                    style="max-height:250px; object-fit:cover;">
                            </div>
                        </div>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mt-4 p-3 rounded-4 shadow-sm"
                        style="background:#ffffffd4; border:1px solid #eee;">
                        <p class="fw-bold">Deskripsi:</p>
                        <p>{{ $detailRoom['description'] ?? '-' }}</p>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="modal-footer flex-wrap gap-2 justify-content-between rounded-bottom-4"
                    style="background: #f7f4ef; border-top: 1px solid #e5e5e5;">

                    <button wire:click="closeDetailModal"
                        class="btn btn-secondary px-4 rounded-3 shadow-sm">
                        Tutup
                    </button>

                    <div class="d-flex flex-wrap gap-2">

                        <button
                            wire:click="addFavorite({{ $detailRoom['id'] ?? 'null' }})"
                            onclick="showPopup('Ditambahkan ke Favorit! ❤️')"
                            class="btn btn-warning px-4 rounded-3 shadow-sm">
                            Favorit
                        </button>

                        <button
                            wire:click="bookRoom({{ $detailRoom['id'] ?? 'null' }})"
                            onclick="showPopup('Booking berhasil dibuat! 📝')"
                            class="btn btn-primary px-4 rounded-3 shadow-sm">
                            Booking
                        </button>

                        <button
                            wire:click="createPayment({{ $detailRoom['id'] ?? 'null' }})"
                            onclick="showPopup('Menu Pembayaran Dibuka! 💰')"
                            class="btn btn-success px-4 rounded-3 shadow-sm">
                            Payment
                        </button>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endif
