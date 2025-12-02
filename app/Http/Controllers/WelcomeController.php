<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
{
    $reviews = Review::with('user')->latest()->get();

    return view('welcome', [
        'reviews' => $reviews
    ]);
    
}
   public function store(Request $request, $roomId)
    {
        $request->validate([
            'comment' => 'required|min:3',
        ]);

        Review::create([
            'room_id' => $roomId,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review berhasil ditambahkan!');
    }
}
