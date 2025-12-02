<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.admin')]
class Edit extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $editingId;
    public $name, $address, $price, $capacity, $status;
    public $newImage; // Untuk upload baru
    public $oldImage; // Path gambar lama
    public $description;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'price' => 'required|numeric|min:1000',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,penuh',
            'newImage' => 'nullable|image|max:1024',
            'description' => 'nullable|string',

        ];
    }

    protected $listeners = ['openEditModal' => 'loadRoom'];

    public function loadRoom($id)
    {
        $room = Room::findOrFail($id);
        
        $this->resetValidation();
        $this->reset(['newImage']); // Reset hanya file upload
        
        $this->editingId = $room->id;
        $this->name = $room->name;
        $this->address = $room->address;
        $this->price = $room->price;
        $this->capacity = $room->capacity;
        $this->status = $room->status;
        $this->oldImage = $room->image;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
        $this->reset(['editingId', 'oldImage']);
    }

    public function update()
    {
        $this->validate();

        $room = Room::find($this->editingId);
        $imagePath = $this->oldImage;

        if ($this->newImage) {
            // Hapus gambar lama dan simpan yang baru
            if ($this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $imagePath = $this->newImage->store('rooms', 'public');
        }

        $room->update([
            'name' => $this->name,
            'address' => $this->address,
            'price' => $this->price,
            'capacity' => $this->capacity,
            'status' => $this->status,
            'is_available' => ($this->status === 'active'),
            'image' => $imagePath,
            'description' => $this->description,

        ]);

        session()->flash('success', 'Kamar berhasil diperbarui!');
        $this->closeModal();
        
        // Dispatch event untuk me-refresh component utama (Rooms.php)
        $this->dispatch('roomSaved'); 
    }

    public function render()
    {
        // View ini harus merender modal form Edit Kamar
        return view('livewire.admin.edit');
    }
}