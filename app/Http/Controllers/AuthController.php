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
            'email' => 'required|email|max:50|unique:user,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        DB::table('user')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
        ]);

        return redirect()->route('login.form')->with('success', 'Berhasil register! Silakan login.');
    }

    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
   // Proses login
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = DB::table('user')->where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        session(['user_id' => $user->user_id, 'nama' => $user->nama]);
        return redirect()->route('produk.list')->with('success', 'Berhasil login!');
    } // <<< INI KURUNG KURAWAL YANG KAMU LUPA

    return back()->withErrors([
        'email' => 'Email atau Password salah.',
    ]);
}


    // Proses logout
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login.form')->with('success', 'Berhasil logout.');
    }
}
