<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="tab-content mt-4" id="userPanelTabContent">

                {{-- ===========================
                     TAB: BOOKINGS
                =========================== --}}
                @if($activeTab === 'bookings')
<div class="tab-pane fade show active">

    <h4 class="section-title">My Bookings</h4>

    @if(isset($bookings) && $bookings->count() > 0)

        <div class="row">
            @foreach($bookings as $booking)
            <div class="col-md-4 mb-4">
                <div class="card vintage-card rounded-md">

                    <img src="{{ $booking->room?->image_url ?? '/no-image.png' }}"
                         class="card-img-top"
                         style="height:230px; object-fit:cover;">

                    <div class="card-body">
                        <h5 class="fw-bold">{{ $booking->room?->name ?? 'Room not found' }}</h5>
                        <p class="text-muted mb-1">{{ $booking->room?->address ?? '-' }}</p>
                        <p><strong>Booked:</strong> {{ $booking->created_at->format('d M Y') }}</p>

                        <div class="d-flex gap-2">
                           <button class="btn btn-sm btn-vintage"
                            wire:click="viewRoomDetail({{ $booking->room_id ?? $booking->room->id }})">
                            <i class="fas fa-eye"></i> Detail
                        </button>

                            <button wire:click="deleteBooking({{ $booking->id }})"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus booking ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        {{ $bookings->links() }}

    @else
        <p class="text-muted">Tidak ada bookings ditemukan.</p>
    @endif

</div>
@endif

                {{-- ===========================
                     TAB: FAVORITES (TABEL)
                =========================== --}}
                @if($activeTab === 'favorites')
<div class="tab-pane fade show active">

    <h4 class="section-title">My Favorites</h4>

    @if(isset($favorites) && $favorites->count() > 0)

        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-3 vintage-table">
                <thead>
                    <tr>
                        <th>Nama Kamar</th>
                        <th>Alamat</th>
                        <th>Harga</th>
                        <th>Ditambahkan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($favorites as $favorite)
                    <tr>
                        <td>{{ $favorite->room?->name ?? 'Room not found' }}</td>
                        <td>{{ $favorite->room?->address ?? '-' }}</td>
                        <td>Rp {{ number_format($favorite->room?->price ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $favorite->created_at->format('d M Y') }}</td>

                        <td>
                            <button wire:click="deleteFavorite({{ $favorite->id }})"
                                    class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $favorites->links() }}

    @else
        <p class="text-muted">No favorites found.</p>
    @endif

</div>
@endif

                {{-- ===========================
                     TAB: PAYMENTS (TABEL)
                =========================== --}}
               @if($activeTab === 'payments')
<div class="tab-pane fade show active">

    <h4 class="section-title">My Payments</h4>

    @if(isset($payments) && $payments->count() > 0)

        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-3 vintage-table">
                <thead>
                    <tr>
                        <th>Kamar</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>
                            {{ $payment->booking?->room?->name
                                ?? $payment->room?->name
                                ?? 'Tidak ada data kamar' }}
                        </td>

                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>

                        <td>
                            @if($payment->status === 'lunas')
                                <span class="badge bg-success">Lunas</span>
                            @elseif($payment->status === 'pending')
                                <span class="badge bg-warning text-white">Pending</span>
                            @else
                                <span class="badge bg-danger">Gagal</span>
                            @endif
                        </td>

                        <td>{{ $payment->created_at->format('d M Y') }}</td>

<td>
    @if ($payment->status === 'lunas')

        <button wire:click="print({{ $payment->id }})" class="btn btn-success btn-sm">
            <i class="fa fa-print"></i>
        </button>

    @elseif ($payment->status === 'pending')

        @if (isset($uploadedPayment[$payment->room_id]) && $uploadedPayment[$payment->room_id] == true)

            {{-- Tombol jadi icon mata --}}
            <button 
                wire:click="lihatBukti({{ $payment->id }})" 
                class="btn btn-primary btn-sm">
                <i class="fa fa-eye"></i>
            </button>

        @else

            {{-- Tombol Kirim --}}
            <button 
                wire:click="$set('roomId', {{ $payment->room_id }})"
                data-bs-toggle="modal" 
                data-bs-target="#uploadModal"
                class="btn btn-info btn-sm">
                Kirim
            </button>

        @endif

    @else

        <button class="btn btn-secondary btn-sm">❌</button>

    @endif

    <button wire:click="deletePayment({{ $payment->id }})" class="btn btn-danger btn-sm">
        <i class="fas fa-trash"></i>
    </button>
</td>

                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $payments->links() }}

    @else
        <p class="text-muted">No payments found.</p>
    @endif

</div>
@endif

            </div>
        </div>
    </div>

{{-- ===========================
    MODAL DETAIL KAMAR
=========================== --}}
@if($showRoomDetailModal && $selectedRoom)
    <div class="modal-backdrop fade show"></div>

    <div class="modal fade show d-block" style="z-index:1050;" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">{{ $selectedRoom->name ?? 'Detail Kamar' }}</h5>
                    <button type="button" class="btn-close" wire:click="$set('showRoomDetailModal',
                     false)"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <img src="{{ $selectedRoom->image_url ?? '/no-image.png' }}"
                             class="img-fluid rounded" alt="Foto Kamar">
                        </div>
                        <div class="col-md-6">
                            <h5>Informasi Kamar</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Harga:</strong> Rp 
                                    {{ number_format($selectedRoom->price, 0, ',', '.') }}/bulan</li>
                                <li class="list-group-item"><strong>Kapasitas:</strong> 
                                    {{ $selectedRoom->capacity }} orang</li>
                                <li class="list-group-item"><strong>Alamat:</strong>
                                     {{ $selectedRoom->address }}</li>
                            </ul>
                            
                            <h5 class="mt-3">Deskripsi</h5>
                            <p>{{ $selectedRoom->description }}</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set
                    ('showRoomDetailModal', false)">Tutup</button>
                </div>

            </div>
        </div>
    </div>
@endif

<!-- UPLOAD PROOF MODAL -->
<div wire:ignore.self class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="uploadProof">
                
                <div class="modal-header">
                    <h5 class="modal-title">Kirim Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- PREVIEW GAMBAR -->
                    @if ($proof_image)
                        <img src="{{ $proof_image->temporaryUrl() }}" class="img-fluid mb-3 rounded">
                    @endif

                    <input type="file" class="form-control" wire:model="proof_image">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal</button>
                    <button class="btn btn-primary">Kirim</button>
                </div>

            </form>
        </div>
    </div>
</div>

  @if($showImageModal)
    <div class="modal-backdrop fade show"></div>

    <div class="modal fade show d-block" style="z-index:1050;" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" wire:click="$set('showImageModal', false)">
                    </button>
                </div>

                <div class="modal-body text-center">
                    <img src="{{ asset('storage/' . $selectedImage) }}" class="img-fluid rounded">
                </div>

            </div>
        </div>
    </div>
@endif


<style>
    body{
        padding-top: 80px;
    }

    .section-title {
        font-weight: 700;
        font-size: 1.7rem;
        color: #5c3d2e;
        border-left: 6px solid #caa074;
        padding-left: 12px;
        margin-bottom: 20px;
        letter-spacing: 1px;
    }

    .vintage-card {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        background: #fff8ef;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        transition: .3s;
    }

    .vintage-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .vintage-table th {
        background: #4b3226 !important;
        color: #f3d9b1;
        font-weight: 700;
    }

    .modal-header {
        background: #4b3226;
        color: #f9e6c7;
        border-bottom: none;
    }

    .modal-content {
        border-radius: 14px;
        overflow: hidden;
        background: #fffaf2;
    }
</style>
</div>

@push('scripts')
<script>
// Debug: Cek apakah Bootstrap & jQuery sudah loaded
console.log('jQuery version:', typeof $ !== 'undefined' ? $.fn.jquery : 'Not loaded');
console.log('Bootstrap version:', typeof bootstrap !== 'undefined' ? 'Loaded ✅' : 'Not loaded ❌');

$(document).ready(function() {
    console.log('Document ready!');
    
    // Hitung total modal di halaman
    const totalModals = $('.modal').length;
    console.log('Total modals:', totalModals);
    
    // Test klik tombol modal
    $('button[data-bs-toggle="modal"]').on('click', function() {
        const target = $(this).data('bs-target');
        console.log('Modal button clicked! Target:', target);
    });
    
    // Event saat modal dibuka
    $('.modal').on('show.bs.modal', function (e) {
        console.log('Modal opening:', this.id);
    });
    
    // Event saat modal ditutup
    $('.modal').on('hidden.bs.modal', function (e) {
        console.log('Modal closed:', this.id);
        
        // Cleanup backdrop jika ada yang tertinggal
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('overflow', '');
    });

});

document.addEventListener('livewire:init', () => {

    // Tutup modal
    Livewire.on('hide-upload-modal', () => {
        const modalEl = document.getElementById('uploadModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();

        // cleanup backdrop
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('modal-open');
        document.body.style = '';
    });

    // Reset input file + hapus preview
    Livewire.on('reset-upload-form', () => {
        const input = document.querySelector('#uploadModal input[type="file"]');
        if (input) input.value = "";
        
        // Hapus preview image
        const img = document.querySelector('#uploadModal img');
        if (img) img.remove();
    });

});

window.addEventListener('close-upload-modal', () => {
        const modal = bootstrap.Modal.getInstance(
            document.getElementById('uploadModal')
        );
        modal.hide();
    });


</script>
@endpush