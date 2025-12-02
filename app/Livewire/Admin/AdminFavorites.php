<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Favorite;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class AdminFavorites extends Component
{
    use WithPagination;

    public $perPage = 10;

    public function render()
    {
        
        $favorites = Favorite::with(['user', 'room.owner'])
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPage);

        return view('livewire.admin.admin-favorites', compact('favorites'));
    }
}
