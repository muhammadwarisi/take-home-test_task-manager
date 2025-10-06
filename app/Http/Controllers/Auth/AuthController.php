<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function loginForm()
    {
        return view('auth.login');
    }
    public function register(AuthRequest $authRequest)
    {
        $this->authService->register($authRequest);
        return view('auth.register');
    }
    public function login(AuthRequest $authRequest)
    {
        $credentials = $authRequest->only('email', 'password');
        $rememberMe = $authRequest->only('remember-me') ? true : false;
        if (Auth::attempt($credentials, $rememberMe)) {
            // jika berhasil, lanjut ke dashboard
            Log::info('User ' . auth()->user()->name . ' berhasil login');
            Alert::success('Login Berhasil', 'Selamat datang ' . auth()->user()->name);
            return to_route('dashboard')->with('success', 'Login berhasil!');
        } else {
            // jika gagal, kembali ke halaman login dengan pesan error
            Alert::error('Login Gagal', 'Email atau password salah');
            return redirect()->route('login-form')->withErrors(['email' => 'Email atau password salah'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
