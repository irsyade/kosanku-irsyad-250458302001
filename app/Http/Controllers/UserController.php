<?php

namespace App\Http\Controllers;

use App\Models\Room;

class UserController extends Controller
{
    public function userRooms()
    {
        // hanya tampilkan kamar aktif & tersedia
        $rooms = Room::where('status', 'active')
                     ->where('is_available', true)
                     ->get();

        return view('user.roms', compact('rooms'));
    }
}
