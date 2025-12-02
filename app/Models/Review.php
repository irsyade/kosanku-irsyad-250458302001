<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'kos_name',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

