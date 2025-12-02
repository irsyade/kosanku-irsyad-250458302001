<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Create extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $name, $address, $price, $capacity, $image, $status = 'active';
    public $description; // DITAMBAHKAN

    protected $rules = [
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'price' => 'required|numeric|min:1000',
        'capacity' => 'required|integer|min:1',
        'status' => 'required|in:active,inactive,penuh',
        'image' => 'required|image|max:2048',
        'description' => 'nullable|string',
    ];

    protected $listeners = ['openCreateModal' => 'showModal'];

    public function showModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'address', 'price', 'capacity', 'image', 'description']);
        $this->status = 'active';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        $imagePath = $this->image->store('rooms', 'public');

        Room::create([
    'name' => $this->name,
    'address' => $this->address,
    'price' => $this->price,
    'capacity' => $this->capacity,
    'status' => $this->status,
    'is_available' => ($this->status === 'active'),
    'image' => $imagePath,
    'description' => $this->description,
    'owner_id' => auth()->id(), // <── WAJIB ADA
]);


        session()->flash('success', 'Kamar baru berhasil ditambahkan!');
        $this->closeModal();

        $this->dispatch('roomSaved'); 
    }

    public function render()
    {
        return view('livewire.admin.create');
    }
}
