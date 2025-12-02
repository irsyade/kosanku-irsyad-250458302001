<?php

use App\Livewire\Admin\Rooms;

// USER CONTROLLERS

use App\Livewire\User\HomePage;

use App\Livewire\User\RoomList;

use App\Livewire\User\UserPanel;

// ADMIN CONTROLLERS

use App\Livewire\Admin\BookingList;

use App\Livewire\Admin\AdminPayments;

use Illuminate\Support\Facades\Route;

use App\Livewire\Admin\AdminDashboard;

use App\Livewire\Admin\AdminFavorites;

// CUSTOM CONTROLLERS

use App\Http\Controllers\AuthController;

use App\Http\Controllers\RoomController;

use App\Http\Controllers\ReviewController;

use App\Http\Controllers\PaymentController;

use App\Http\Controllers\WelcomeController;

use App\Http\Controllers\UserPaymentController;

// ========================
// PUBLIC ROUTE
// ========================

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// ========================
// AUTH ROUTES
// ========================
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginproses')->name('login.proses');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerproses')->name('register.proses');

    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});


// ========================
// USER ROUTES
// ========================
Route::middleware(['auth', 'role:user'])->group(function () {

    // Dashboard user
    Route::get('/dashboard', HomePage::class)->name('home');

    // Room list user
    Route::get('/user/rooms', RoomList::class)->name('rooms');
    
    Route::get('/room/{id}', [RoomController::class, 'show'])->name('user.room-detail');

    // MASIH DALAM SATU COMPONENT (TAB)
    Route::get('/bookings', UserPanel::class)->name('bookings');
    Route::get('/favorites', UserPanel::class)->name('favorites');
    Route::get('/payments', UserPanel::class)->name('payments');

    // REVIEW STORE (Fix)
   Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/user/payments/print/{id}', [UserPaymentController::class, 'print'])
        ->name('user.payments.print');

});


// ========================
// ADMIN ROUTES
// ========================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard admin
    Route::get('/admin/dashboard', AdminDashboard::class)
        ->name('admin.dashboard');

    // Rooms
    Route::get('/admin/rooms', Rooms::class)->name('admin.rooms');

    // Booking list
    Route::get('/admin/bookings', BookingList::class)
        ->name('admin.bookings.index');

    // Payments
    Route::get('/admin/payments', AdminPayments::class)
        ->name('admin.payments.index');

    Route::get('/admin/payments/print/{paymentId}', 
        [PaymentController::class, 'print'])
        ->name('admin.payments.print');

    // Favorites
    Route::get('/admin/favorites', AdminFavorites::class)
        ->name('admin.favorites.index');
});
