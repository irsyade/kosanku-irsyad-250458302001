<div>
    <div class="container mt-4">
        <h2 class="mb-4 text-vintage fw-bold">Data Booking Pengguna</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Search Bar -->
        <div class="mb-3">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
             placeholder="Cari berdasarkan nama user atau kamar...">
        </div>

        @if($bookings->count())
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle
                 bg-white shadow-sm rounded-md-2">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama User</th>
                            <th>Nama Kamar</th>
                            <th>Tanggal Booking</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $index => $booking)
                            <tr>
                                <td>{{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings
                                ->perPage() }}</td>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->room->name }}</td>
                                <td>{{ $booking->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            wire:click="delete({{ $booking->id }})"
                                            onclick="return confirm('Yakin mau hapus data ini?')">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="alert alert-info">Belum ada data booking.</div>
        @endif
    </div>

    <style>
    .text-vintage-dark { color: #3b2f2f; }
    body { padding-top: 20px; }
    </style>
</div>