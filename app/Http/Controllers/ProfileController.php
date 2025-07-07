<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Relasi orders dan orderItems harus ada di model User
        $pesanan = $user->orders()->with('orderItems.kuliner')->latest()->get();

        return view('profil', [
            'user' => $user,
            'pesanan' => $pesanan
        ]);
    }

    public function updateAlamat(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->alamat_pengiriman = $request->alamat_pengiriman;
        $user->save();

        return redirect()->route('profil.index')->with('success', 'Alamat berhasil diperbarui!');
    }
}
