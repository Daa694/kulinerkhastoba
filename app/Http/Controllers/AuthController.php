<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:30',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($request->email === 'admin@admin.com') {
            // Admin: password tidak di-hash (plain text)
            DB::table('users')->insert([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'admin',
                'created_at' => now(),
            ]);
        } else {
            // User: password di-hash
            DB::table('users')->insert([
                'name' => $request->nama, // ganti 'nama' menjadi 'name' sesuai kolom tabel
                'email' => $request->email,
                'password' => Hash::make($request->password), // simpan password dengan hash
                'role' => 'user', // default user biasa
                'created_at' => now(),
            ]);
        }

        return redirect()->route('login.form')->with('success', 'Berhasil register! Silakan login.');
    }

    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();
        if ($user) {
            if ($user->role === 'admin') {
                // Admin: cek password plain text (tidak di-hash)
                if ($request->password === $user->password) {
                    session(['user_id' => $user->id, 'user_nama' => $user->name, 'user_role' => $user->role]);
                    return redirect()->route('dashboard');
                }
            } else {
                // User: cek password hash
                if (Hash::check($request->password, $user->password)) {
                    session(['user_id' => $user->id, 'user_nama' => $user->name, 'user_role' => $user->role]);
                    return redirect()->route('produk');
                }
            }
        }
        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    // Proses logout
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login.form');
    }
}
