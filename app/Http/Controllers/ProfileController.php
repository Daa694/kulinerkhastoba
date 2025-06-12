<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        return view('profil');
    }

    public function updateAlamat(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:255',
        ]);

        auth()->user()->update([
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('profil.index')->with('success', 'Alamat berhasil diupdate!');
    }
}