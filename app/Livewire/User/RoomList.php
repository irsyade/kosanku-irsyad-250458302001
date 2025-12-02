<?php

namespace App\Livewire\User;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Livewire\Component;
use App\Models\Favorite;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder; // Import Builder

#[Layout('layouts.app')]
class RoomList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedRoomId = null;

    public $showDetailModal = false;
    public $detailRoom = [];

    // Gunakan 'room-list' sebagai nama pagination
    protected $paginationTheme = 'bootstrap';

    // Anda mungkin perlu me-refresh list saat ada aksi di komponen lain
    protected $listeners = ['roomStatusUpdated' => '$refresh'];

   public function updatedSearch()
{
    $this->resetPage();
}

    public function searchRooms()
{
    $this->resetPage();
}


    // =======================================
    // MODAL DETAIL
    // =======================================
    public function openDetail($id)
    {
        $room = Room::find($id);

        if (!$room) return;

        // Perbaikan path image
        if ($room->image) {
            $imagePath = asset('storage/' . $room->image);
        } else {
            // Gunakan default image dari public/images
            $imagePath = asset('images/default.png'); // Bukan storage/rooms/default.png
        }

        $this->detailRoom = [
            'id'            => $room->id,
            'name'          => $room->name,
            'address'       => $room->address,
            'description'   => $room->description,
            'price'         => $room->price,
            'capacity'      => $room->capacity,
            'status'        => $room->status,
            'image_url'     => $imagePath,
            'is_favorited'  => Auth::check()
                ? Favorite::where('user_id', Auth::id())
                ->where('room_id', $room->id)
                ->exists()
                : false,
        ];

        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->detailRoom = []; // Bersihkan data detail setelah ditutup
    }

    # =======================================
    # FAVORIT
    # =======================================
    public function addFavorite($roomId)
    {
        if (!Auth::check()) {
            return $this->redirect(route('login')); // Arahkan ke login jika belum login
        }

        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'room_id' => $roomId,
        ]);

        // Cek apakah data baru dibuat atau sudah ada (untuk pesan)
        if ($favorite->wasRecentlyCreated) {
            session()->flash('success', 'Kamar ditambahkan ke favorit!');
        } else {
            session()->flash('info', 'Kamar sudah ada di daftar favorit.');
        }

        $this->dispatch('alert', message: 'Berhasil menambah favorit!');
    }

    # =======================================
    # BOOKING
    # =======================================
    public function bookRoom($roomId)
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $room = Room::find($roomId);
        if (!$room) {
            session()->flash('error', 'Kamar tidak ditemukan.');
            return;
        }

        // Opsi: Cek jika user sudah pernah booking kamar ini dengan status pending/confirmed
        // Optional: Anda bisa menambahkan logika pengecekan di sini

        Booking::create([
            'user_id' => auth()->id(),
            'room_id' => $roomId,
            'status' => 'pending',
            'amount' => $room->price,
            'start_date' => now()->startOfDay(),
            'end_date' => now()->addMonth()->startOfDay(),
        ]);

        session()->flash('success', 'Booking berhasil dibuat! Silakan cek halaman My Bookings.');

        $this->dispatch('alert', message: 'Booking berhasil!');

    }


    # =======================================
    # PAYMENT
    # =======================================
    public function createPayment($roomId)
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $room = Room::find($roomId);

        if (!$room) {
            session()->flash('error', 'Kamar tidak ditemukan.');
            return;
        }

        // 🚨 PERHATIAN: Payment biasanya terkait dengan Booking, bukan langsung dengan Room.
        // Asumsi: Jika user langsung membuat payment, ini adalah payment pertama/DP

        Payment::create([
            'user_id' => Auth::id(),
            'room_id' => $roomId,
            'amount'  => $room->price,
            'status'  => 'pending',
            'proof_image' => null
            // Tambahkan kolom lain seperti 'payment_method' atau 'booking_id' jika perlu
        ]);

        session()->flash('success', 'Pembayaran berhasil dibuat, upload bukti di halaman pembayaran!');

         $this->dispatch('alert', message: 'Silakan lanjut ke pembayaran!');
    }

    // public $comment;
    // public $roomId;

    // Dipanggil saat modal dibuka

    // public function uploadReview($id)
    // {
    //     $this->validate([
    //         'comment' => 'required|min:3'
    //     ]);

    //     Review::create([
    //         'room_id' => $id,
    //         'user_id' => Auth::id(),
    //         'comment' => $this->comment
    //     ]);

    //     // reset input
    //     $this->reset('comment');


    //     session()->flash('success', 'Review berhasil ditambahkan!');
    // }

    

    # =======================================
    # RENDER
    # =======================================
public function render()
{
    $rooms = Room::query()
        ->where('status', '!=', 'nonaktif')
        ->when(strlen($this->search) > 0, function (Builder $query) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('address', 'like', "%{$this->search}%");
            });
        })
        ->orderByDesc('created_at')
        ->paginate(9);

    $rooms->getCollection()->transform(function ($room) {
        $room->image_url = $room->image
            ? asset('storage/' . $room->image)
            : asset('images/no-image.jpg');
        return $room;
    });

    return view('livewire.user.room-list', compact('rooms'));
}
}

