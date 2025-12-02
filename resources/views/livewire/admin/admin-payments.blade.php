<div>
    <style>
        body {
            padding-top: 20px; 
        }

        .modal-header {
            background: #4b3226;
            color: #f9e6c7;
            border-bottom: none;
        }
    </style>
    
    <div class="container mt-4">
        <h3 class="mb-4 fw-bold text-vintage">Daftar Pembayaran</h3>

        {{-- Success Message --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($payments->count())
            <table class="table table-striped table-bordered align-middle rounded-4">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>User</th>
                        <th>Room</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $p)
                        <tr>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td>{{ $p->room->name ?? '-' }}</td>
                            <td>Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($p->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif($p->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-danger">{{ $p->status }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form method="GET" action="">
                                    @csrf
                                    <div class="">
                                        <button wire:click="verify({{ $p->id }})" class="btn btn-success btn-sm">
                                            Verify</button>
                                        <button wire:click="reject({{ $p->id }})" class="btn btn-danger btn-sm">
                                            Reject</button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <button wire:click="lihatBukti({{ $p->id }})" class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i>
                                </button>
                                
                                <button wire:click="print({{ $p->id }})" class="btn btn-secondary btn-sm">
                                    <i class="fa fa-print"></i>
                                </button>                              
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

             <div class="d-flex justify-content-center mt-3">
                {{ $payments->links() }}
            </div>
        @else
            <div class="alert alert-info text-center mt-4">
                Tidak ada data pembayaran untuk saat ini.
            </div>
        @endif
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

</div>
