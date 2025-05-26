<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    // Method untuk menampilkan profil pengguna
    public function index(Request $request)
    {
        // Ambil user_id dari session
        $userId = session('user_id');

        // Ambil data user dari tabel 'users'
        // Pastikan untuk memilih field 'alamat_pengiriman' agar ada pada hasil query
        $user = DB::table('users')
            ->select('id', 'name', 'alamat_pengiriman') // gunakan 'name' bukan 'nama'
            ->where('id', $userId)
            ->first();

        // Gunakan helper optional() agar jika $user null atau properti tidak tersedia, tidak terjadi error
        $alamat = optional($user)->alamat_pengiriman ?? '';
        $nama = optional($user)->name ?? '';

        // Ambil data pesanan berdasarkan user_id
        $pesanan = DB::table('orders')
            ->where('user_id', $userId)
            ->get();

        // Ambil data keranjang user yang belum checkout
        $keranjang = DB::table('carts')
            ->join('kuliners', 'carts.kuliner_id', '=', 'kuliners.id')
            ->select('carts.*', 'kuliners.nama', 'kuliners.harga')
            ->where('carts.user_id', $userId)
            ->where('carts.is_checked_out', false)
            ->get();

        // Kembalikan data ke view 'profil'
        return view('profil', compact('alamat', 'pesanan', 'nama', 'keranjang'));
    }
    
    // Method untuk memperbarui alamat pengiriman pengguna
    public function updateAlamat(Request $request)
    {
        $userId = session('user_id');

        // Update kolom 'alamat_pengiriman' untuk user tertentu dengan data dari input form
        DB::table('users')
            ->where('id', $userId)
            ->update([
                'alamat_pengiriman' => $request->input('alamat_pengiriman') // ambil input secara eksplisit
            ]);

        // Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profil')->with('success', 'Alamat pengiriman berhasil diperbarui!');
    }
}
