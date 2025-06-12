<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            // Check if user exists first
            $user = User::where('email', $credentials['email'])->first();
            
            if (!$user) {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors([
                        'email' => 'Email tidak ditemukan dalam sistem.'
                    ]);
            }

            // Check if trying to login from admin page
            $isAdminLogin = $request->is('admin/login') || $request->is('admin/*');
            
            // If admin page but not admin user
            if ($isAdminLogin && $user->role !== 'admin') {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors([
                        'email' => 'Akses tidak diizinkan. Hanya untuk admin.'
                    ]);
            }
            
            // If regular page but admin user
            if (!$isAdminLogin && $user->role === 'admin') {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors([
                        'email' => 'Silakan gunakan halaman login admin.'
                    ]);
            }

            // Attempt to log in
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                
                // Redirect based on role
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                
                return redirect()->route('menu');
            }

            // If we reach here, the password was wrong
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'password' => 'Password yang Anda masukkan salah.'
                ]);
        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Terjadi kesalahan saat login. Silakan coba lagi.'
                ]);
        }
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat_pengiriman' => 'required|string'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'alamat_pengiriman' => $validated['alamat_pengiriman'],
            'role' => 'user'
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silahkan login dengan akun anda.');
    }    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout');
    }
}
