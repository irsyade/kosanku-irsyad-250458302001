<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Rooms extends Component
{
    use WithPagination;

    public $search = '';
    public $deleteId; 

    protected $listeners = [
        'confirmedDelete' => 'deleteRoom'
    ];

    public function confirmDelete($id)
    {
        $room = Room::find($id);

        if (!$room) return;

        $this->dispatch('showDeleteConfirmation', [
            'room_id'   => $room->id,
            'room_name' => $room->name,
        ]);
    }

  public function delete($id)
{
    $room = Room::findOrFail($id);

    if ($room->image) {
        Storage::disk('public')->delete($room->image);
    }

    $room->delete();
}


    public function render()
    {
        return view('livewire.admin.rooms', [
            'rooms' => Room::where('name', 'like', "%{$this->search}%")->paginate(5)
        ]);
    }
}
