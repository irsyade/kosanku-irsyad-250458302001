<div class="container mt-4">

    {{-- Success Alert --}}
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Review --}}
    <div class="card mb-4">
        <div class="card-body">

            <h5 class="mb-3">Tulis Review Kamu</h5>

            <div class="mb-3">
                <label class="form-label">Komentar</label>
                <textarea wire:model="comment" class="form-control" rows="3"></textarea>
                @error('comment') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button wire:click="submitReview" class="btn btn-primary">
                Kirim Review
            </button>

        </div>
    </div>

    {{-- List Review --}}
    <h5 class="mb-3">📄 Review Lainnya</h5>

    @forelse ($reviews as $r)
        <div class="card mb-2">
            <div class="card-body">
                <strong>{{ $r->user->name }}</strong>
                <p class="mt-2">{{ $r->comment ?? '-' }}</p>

                <small class="text-muted">
                    {{ $r->created_at->diffForHumans() }}
                </small>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Belum ada review untuk kamar ini.</div>
    @endforelse

</div>
