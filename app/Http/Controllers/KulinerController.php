<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use Illuminate\Http\Request;

class KulinerController extends Controller
{
    // Daftar produk/menu
    public function index(Request $request)
    {
        $query = Kuliner::query();
        if ($request->has('q') && $request->q) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }
        $kuliners = $query->get();
        return view('produk_list', compact('kuliners'));
    }

    // Detail produk/menu
    public function show(Kuliner $kuliner)
    {
        // Jika ingin menampilkan rating, pastikan relasi sudah ada
        // $kuliner->loadAvg('ratings', 'rating');
        // $kuliner->ratings_count = $kuliner->ratings()->count();

        return view('detail', compact('kuliner'));
    }

    // Tambah ke keranjang (contoh, harus login)
    public function tambahKeranjang(Request $request, Kuliner $kuliner)
    {
        // HARUS pakai Auth::id() untuk deteksi login Laravel
        if (!auth()->check()) {
            return redirect()->route('login.form')->with('error', 'Silakan login terlebih dahulu!');
        }
        $userId = auth()->id();

        $jumlah = $request->input('jumlah', 1);
        $cart = \App\Models\Cart::where('user_id', $userId)
            ->where('kuliner_id', $kuliner->id)
            ->where('is_checked_out', false)
            ->first();
        if ($cart) {
            $cart->jumlah += $jumlah;
            $cart->save();
        } else {
            \App\Models\Cart::create([
                'user_id' => $userId,
                'kuliner_id' => $kuliner->id,
                'jumlah' => $jumlah,
                'is_checked_out' => false
            ]);
        }
        return redirect()->route('profil')->with('success', 'Produk berhasil dimasukkan ke keranjang!');
    }

    // Contoh jika ingin fitur rating produk
    public function beriRating(Request $request, Kuliner $kuliner)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);
        // Misal relasi: $kuliner->ratings() -> Model Rating harus dibuat, dan ada kolom user_id, kuliner_id, rating
        $kuliner->ratings()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['rating' => $request->rating]
        );
        return back()->with('success', 'Rating berhasil disimpan!');
    }
}