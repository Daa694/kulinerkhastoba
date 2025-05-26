<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KulinerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kuliner::query();
        if ($request->has('q') && $request->q) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }
        $kuliners = $query->get();
        return view('produk_list', compact('kuliners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kuliner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'gambar_kuliner' => 'nullable|string',
            'rating' => 'nullable|numeric',
        ]);
        Kuliner::create($request->all());
        return redirect()->route('produk')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kuliner $kuliner)
    {
        return view('detail_kuliner', compact('kuliner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kuliner $kuliner)
    {
        if (Auth::id() !== $kuliner->user_id) {
            return redirect()->route('produk')->with('error', 'Anda tidak memiliki izin untuk mengedit data ini.');
        }
        return view('kuliner.edit', compact('kuliner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kuliner $kuliner)
    {
        if (Auth::id() !== $kuliner->user_id) {
            return redirect()->route('produk')->with('error', 'Anda tidak memiliki izin untuk mengupdate data ini.');
        }

        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'gambar_kuliner' => 'nullable|string',
            'rating' => 'nullable|numeric',
        ]);
        $kuliner->update($request->all());
        return redirect()->route('produk')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kuliner $kuliner)
    {
        if (Auth::id() !== $kuliner->user_id) {
            return redirect()->route('produk')->with('error', 'Anda tidak memiliki izin untuk menghapus data ini.');
        }

        $kuliner->delete();
        return redirect()->route('produk')->with('success', 'Data berhasil dihapus');
    }

    // User menambah produk ke keranjang
    public function tambahKeranjang(Request $request, Kuliner $kuliner)
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('login.form')->with('error', 'Silakan login terlebih dahulu!');
        }
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
}
