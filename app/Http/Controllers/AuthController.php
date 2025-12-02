<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==========================
    // FORM LOGIN
    // ==========================
    public function login()
    {
        return view('auth.login');
    }

    // ==========================
    // PROSES LOGIN
    // ==========================
    public function loginproses(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required'    => 'Email tidak boleh kosong.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min'      => 'Password minimal 8 karakter.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            return $user->role === 'admin'
                ? redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!')
                : redirect()->route('home')->with('success', 'Anda berhasil login!');
        }

        return back()->with('failed', 'Email atau password salah!');
    }

    // ==========================
    // LOGOUT
    // ==========================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout!');
    }

    // ==========================
    // FORM REGISTER
    // ==========================
    public function register()
    {
        return view('auth.register');
    }

    // ==========================
    // PROSES REGISTER
    // ==========================
    public function registerproses(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20|unique:users,phone',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required'        => 'Nama wajib diisi.',
            'email.required'       => 'Email wajib diisi.',
            'email.email'          => 'Format email tidak valid.',
            'email.unique'         => 'Email sudah digunakan.',
            'phone.required'       => 'Nomor telepon wajib diisi.',
            'phone.unique'         => 'Nomor telepon sudah digunakan.',
            'password.required'    => 'Password wajib diisi.',
            'password.min'         => 'Password minimal 8 karakter.',
            'password.confirmed'   => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone, // <-- Tambahan phone
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
