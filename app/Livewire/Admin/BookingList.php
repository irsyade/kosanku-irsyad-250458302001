<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class BookingList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 15;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

public function delete($id)
{
    $booking = Booking::findOrFail($id);

    // Hapus booking
    $booking->delete();

    session()->flash('success', 'Booking berhasil dihapus.');
}

public function book($roomId)
{
    $room = Room::findOrFail($roomId);

    if ($room->available_capacity <= 0) {
        session()->flash('error', 'Kamar sudah penuh!');
        return;
    }

    Booking::create([
        'room_id' => $roomId,
        'user_id' => auth()->id(),
        'status' => 'lunas', // atau 'pending' dulu kalau pakai sistem konfirmasi
    ]);

    session()->flash('success', 'Booking berhasil dibuat!');
}

public function cancelPayment($bookingId)
{
    $booking = Booking::findOrFail($bookingId);

    // hapus payment
    $booking->payment()->delete();

    // ubah status booking supaya tidak dihitung kapasitas
    $booking->update(['status' => 'batal']); 

}

    public function render()
    {
        $bookings = Booking::with('room', 'user')
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('room', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate($this->perPage);

        return view('livewire.admin.booking-list', compact('bookings'));
    }
}
