<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'address',
        'description',
        'price',
        'capacity',
        'image',
        'status', // <– manual status dari admin
    ];

    protected $appends = [
        'filled_capacity',
        'available_capacity',
        'status_ketersediaan'
    ];

    /**
     * RELATION
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * ACCESSOR
     */
    public function getFilledCapacityAttribute()
    {
        return $this->bookings()
            ->where('status', 'lunas')
            ->count();
    }

    public function getAvailableCapacityAttribute()
    {
        return $this->capacity - $this->filled_capacity;
    }

    public function getStatusKetersediaanAttribute()
    {
        if ($this->status) {
            return ucfirst($this->status);
        }

        return $this->available_capacity > 0 ? 'Tersedia' : 'Penuh';
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : '/no-image.png';
    }
}
