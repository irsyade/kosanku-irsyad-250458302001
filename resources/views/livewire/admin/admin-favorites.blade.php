<div>
    <style>
        body { padding-top: 20px; }
    </style>
    
    <div class="container mt-4">
        <h2 class="mb-4 fw-bold text-vintage">Daftar Kamar Favorit Pengguna</h2>
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle rounded-4">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama User</th>
                            <th>Nama Kamar</th>
                            <th>Harga</th>
                            <th>Tanggal Ditambahkan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($favorites as $index => $fav)
                            <tr class="text-center">
                                <td>{{ $favorites->firstItem() + $index }}</td>
                                <td>{{ $fav->user->name ?? 'Tidak diketahui' }}</td>
                                <td>{{ $fav->room->name ?? 'Kamar tidak tersedia' }}</td>
                                <td>Rp{{ number_format($fav->room->price ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $fav->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                        
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data favorit.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $favorites->links() }}
                </div>
            </div>
        
    </div>
</div>

