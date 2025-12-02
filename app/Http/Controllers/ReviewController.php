<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kos_name' => 'required',
            'comment' => 'required|min:3',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'kos_name' => $request->kos_name,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review berhasil ditambahkan!');
    }
}

