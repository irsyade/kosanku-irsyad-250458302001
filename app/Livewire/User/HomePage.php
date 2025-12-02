<?php

namespace App\Livewire\User;

use App\Models\Room;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class HomePage extends Component
{
    public $roomId = null;
    public $room;

    // Dipanggil ketika user klik detail
    public function showRoom($id)
    {
        $this->roomId = $id;

        $this->room = Room::with([
            'owner',
            'bookings.user',
            'favorites.user',
            'payments.user'
        ])->find($id);
    }

    public function backToList()
    {
        $this->roomId = null;
        $this->room = null;
    }

    public function render()
    {
        return view('livewire.user.home-page', [
            'rooms' => Room::latest()->get()
        ]);
    }
}
