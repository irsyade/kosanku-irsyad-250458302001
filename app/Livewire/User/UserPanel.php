<?php

namespace App\Livewire\User;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Livewire\Component;
use App\Models\Favorite;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class UserPanel extends Component
{
    use WithFileUploads;

    public $uploadedPayment = [];
    public $activeTab = 'bookings';
    public $roomId;
    public $proof_image;
    public $selectedRoom;
    public $showRoomDetailModal = false;

    protected $rules = [
        'proof_image' => 'required|image|max:2048'
    ];

    public $selectedImage = null;
    public $showImageModal = false;

    public function mount()
    {
        $currentRoute = request()->route()->getName();

        if (str_contains($currentRoute, 'favorites')) {
            $this->activeTab = 'favorites';
        } elseif (str_contains($currentRoute, 'payments')) {
            $this->activeTab = 'payments';
        } elseif (str_contains($currentRoute, 'bookings')) {
            $this->activeTab = 'bookings';
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function viewRoomDetail($roomId)
    {
        $this->selectedRoom = Room::findOrFail($roomId);
        $this->showRoomDetailModal = true;
    }

    public function uploadProof()
    {
        $this->validate([
            'proof_image' => 'required|image|max:2048',
            'roomId' => 'required'
        ]);

        $room = Room::find($this->roomId);

        if (!$room) {
            session()->flash('error', 'Room tidak ditemukan!');
            return;
        }

        $path = $this->proof_image->store('payments', 'public');

        Payment::where('room_id', $room->id)
            ->where('user_id', auth()->id())
            ->update([
                'proof_image' => $path,
                'status' => 'pending'
            ]);

        session()->flash('success', 'Bukti pembayaran berhasil dikirim!');

        $rid = $this->roomId;

        $this->reset('proof_image', 'roomId');

        $this->uploadedPayment[$rid] = true;

        $this->dispatch('close-upload-modal');
    }

    public function lihatBukti($id)
    {
        $payment = Payment::find($id);

        if ($payment) {
            $this->selectedImage = $payment->proof_image;
            $this->showImageModal = true;
        }
    }

    public function deleteFavorite($id)
    {
        Favorite::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        session()->flash('message', 'Favorit berhasil dihapus.');
    }

    public function deleteBooking($bookingId)
    {
        $booking = Booking::where('user_id', auth()->id())
            ->findOrFail($bookingId);

        $room = $booking->room;
        if ($room) {
            $room->capacity += 1;
            $room->save();
        }

        $booking->delete();

        $this->dispatch('roomDataChanged');
        session()->flash('success', 'Booking berhasil dibatalkan, kapasitas dikembalikan.');
    }

    public function deletePayment($id)
    {
        $payment = Payment::findOrFail($id);
        $room = $payment->room;

        if ($room) {
            $room->capacity += 1;
            $room->save();
        }

        $payment->delete();

        session()->flash('message', 'Payment berhasil dihapus & kapasitas dikembalikan.');
    }

    public function print($paymentId)
    {
        return redirect()->route('user.payments.print', ['id' => $paymentId]);
    }

    public function goToRoomDetail($roomId)
    {
        return redirect()->route('user.room-detail', ['id' => $roomId]);
    }

    public function book($roomId)
    {
        $room = Room::findOrFail($roomId);

        if ($room->capacity <= 0) {
            session()->flash('error', 'Kamar sudah penuh!');
            return;
        }

        $room->capacity -= 1;
        $room->save();

        Booking::create([
            'room_id' => $roomId,
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);

        session()->flash('success', 'Booking berhasil dibuat!');
    }

    public function render()
    {
        $user = Auth::user();
        $data = [];

        if ($this->activeTab === 'bookings') {
            $data['bookings'] = Booking::where('user_id', $user->id)
                ->with(['room', 'payment'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        if ($this->activeTab === 'favorites') {
            $data['favorites'] = Favorite::where('user_id', $user->id)
                ->with('room')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        if ($this->activeTab === 'payments') {
            $data['payments'] = Payment::where('user_id', $user->id)
                ->with('room')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('livewire.user.user-panel', $data);
    }
}
