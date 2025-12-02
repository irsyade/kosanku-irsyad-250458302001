<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Rooms extends Component
{
    use WithPagination;

    public $search = '';

    public function refreshRooms()
    {
        $this->resetPage(); 
        $this->dispatch('$refresh');
          
    }

    public function confirmDelete($id)
    {
        $room = Room::findOrFail($id);
        $this->dispatch('showDeleteConfirmation', [
            'room_id' => $room->id,
            'room_name' => $room->name
        ]);
    }

    public function delete($id)
    {
        // ... (Kode delete tetap sama)
        $room = Room::findOrFail($id);
        $room->delete();

        $this->dispatch('roomDeleted');
        session()->flash('success', 'Kamar telah dihapus.');     
    }

    
    public function render()
    {
$rooms = Room::with('owner')
            ->withCount([
                'bookings as lunas_count' => function ($query) {
                    $query->where('status', 'lunas');
                }
            ])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.admin.rooms', [
            'rooms' => $rooms
        ]);
    }
}