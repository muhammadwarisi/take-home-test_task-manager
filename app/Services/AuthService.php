<?php

namespace App\Services;

use App\Services\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService implements AuthServiceInterface
{
    public function login($credentials)
    {
        // Coba login
        // pecah $credentials menjadi array
        if (Auth::attempt($credentials)) {
            // jika berhasil, lanjut ke dashboard
            Log::info('User ' . auth()->user()->name . ' berhasil login');
        } else {
            // jika gagal, kembali ke halaman login dengan pesan error
            return redirect()->route('login-form')->withErrors(['email' => 'Email atau password salah'])->withInput();
        }
    }

    public function register($request)
    {
        //
    }
}
