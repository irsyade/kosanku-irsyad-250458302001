<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-vintage">
            Manajemen Kamar
        </h2>

        {{-- MEMANGGIL MODAL CREATE --}}
        <button type="button" 
                wire:click='$dispatch("openCreateModal")'
                class="btn btn-vintage rounded-pill px-4">
            + Tambah Kamar
        </button>
    </div>

    <div class="mb-3">
        <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari kamar..." class="form-control rounded-pill">
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">

            <!-- === WRAPPER RESPONSIVE UNTUK TABLE === -->
            <div class="table-responsive-custom">

                <table class="table align-middle table-hover">
                    <thead class="bg-vintage-dark text-white">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Harga</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Pemilik</th>
                            <th>Gambar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rooms as $room)
                            <tr wire:key="room-{{ $room->id }}">
                                <td>{{ $room->id }}</td>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->address }}</td>
                                <td>Rp {{ number_format($room->price,0,',','.') }}</td>
                                
                                <td class="text-center">
                                     {{ $room->capacity }}
                                </td>
                                
                                <td>
                            @if($room->status === 'active')
                                <span class="badge bg-success">Tersedia</span>

                            @elseif($room->status === 'penuh')
                                <span class="badge bg-danger">Penuh</span>

                            @elseif($room->status === 'inactive')
                                <span class="badge bg-secondary">Tidak Aktif</span>

                            @else
                                <span class="badge bg-dark">Unknown</span>
                            @endif
                        </td>
                                                        <td>{{ $room->owner->name ?? '-' }}</td>
                                <td>
                                    @if($room->image)
                                        <img src="{{ asset('storage/'.$room->image) }}" width="70" class="rounded shadow-sm">
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button"
                                        wire:click="$dispatch('openEditModal', { id: {{ $room->id }} })"
                                        class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <button type="button"
                                        wire:click="delete({{ $room->id }})"
                                        class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="fa fa-bed fa-2x mb-2"></i><br>
                                    Belum ada kamar yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div> <!-- END RESPONSIVE WRAPPER -->

            <div class="mt-3">
                {{ $rooms->withQueryString()->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

    {{-- CHILD COMPONENTS --}}
    <livewire:admin.create />
    <livewire:admin.edit />

<style>
    /* ========== RESPONSIVE LAYOUT ========== */

/* Header + Button Tambah */
@media(max-width: 750px) {
    .d-flex h2 {
        font-size: 20px;
    }

    .d-flex button {
        padding: 6px 14px;
        font-size: 14px;
    }
}

/* Input search */
@media(max-width: 750px) {
    .form-control {
        font-size: 14px;
        padding: 10px 14px;
    }
}

/* Card padding di layar kecil */
@media(max-width: 750px) {
    .card-body {
        padding: 10px;
    }
}

/* Table responsive scroll */
.table-responsive-custom {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Table text resizing */
@media(max-width: 750px) {
    table.table th,
    table.table td {
        font-size: 13px;
        white-space: nowrap;
    }

    table.table img {
        width: 55px !important;
    }
}

/* Pagination responsive */
@media(max-width: 576px) {
    nav[role="navigation"] {
        display: flex;
        justify-content: center;
    }

    .pagination {
        font-size: 14px;
    }
}


</style>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
