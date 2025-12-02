<div class="modal fade {{ $showModal ? 'show d-block' : '' }}" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Kamar: {{ $name }}</h5>
                <button type="button" wire:click="closeModal" class="btn-close"></button>
            </div>

            <div class="modal-body">
                <form wire:submit.prevent="update">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Kamar</label>
                            <input type="text" wire:model.defer="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Alamat</label>
                            <input type="text" wire:model.defer="address" class="form-control @error('address') is-invalid @enderror">
                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea wire:model.defer="description" class="form-control"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Harga</label>
                            <input type="number" wire:model.defer="price" class="form-control @error('price') is-invalid @enderror">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Kapasitas</label>
                            <input type="number" wire:model.defer="capacity" class="form-control @error('capacity') is-invalid @enderror">
                            @error('capacity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Status</label>
                            <select wire:model.defer="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active">Tersedia</option>
                                <option value="inactive">Tidak Tersedia</option>
                                <option value="penuh">Penuh</option> 
                            </select>
                             @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Ganti Gambar (Biarkan kosong jika tidak diubah)</label>
                        <input type="file" wire:model="newImage" class="form-control @error('newImage') is-invalid @enderror">
                         @error('newImage') <span class="text-danger">{{ $message }}</span> @enderror

                        @if ($newImage)
                             <p class="mt-2">Preview Gambar Baru:</p>
                             <img src="{{ $newImage->temporaryUrl() }}" width="100" class="rounded">
                        @elseif ($oldImage)
                             <p class="mt-2">Gambar Saat Ini:</p>
                             <img src="{{ asset('storage/'.$oldImage) }}" width="100" class="rounded">
                        @endif
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" wire:click="closeModal" class="btn btn-secondary">Batal</button>
                <button type="button" wire:click="update" class="btn btn-vintage">Simpan Perubahan</button> 
            </div>

        </div>
    </div>
</div>

