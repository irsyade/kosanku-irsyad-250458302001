
<div class="modal fade {{ $showModal ? 'show d-block' : '' }}" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form wire:submit.prevent="save" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kamar Baru</h5>
                    <button type="button" wire:click="closeModal" class="btn-close"></button>
                </div>

                <div class="modal-body">

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
                        <label>Gambar</label>
                        <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror

                        @if($image)
                            <img src="{{ $image->temporaryUrl() }}" width="120" class="mt-2 rounded shadow">
                        @endif
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" wire:click="closeModal" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-vintage">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>
