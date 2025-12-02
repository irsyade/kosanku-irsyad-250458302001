<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Tentukan di mana pengguna harus dialihkan setelah otentikasi.
     * Ubah ini menjadi rute yang dilindungi auth (misalnya /dashboard).
     */
    public const HOME = '/dashboard';

    // ... (sisa method boot dan configureRateLimiting)
    // Anda bisa menyalin sisa kodenya dari instalasi Laravel baru atau dari dokumentasi.
    
    // ...
}