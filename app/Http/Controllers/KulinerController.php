<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KulinerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
        // Guest bisa akses rekomendasi
        $this->middleware('auth')->except(['rekomendasi']);
    }

    public function index()
    {
        $kuliners = Kuliner::withAvg('ratings', 'rating')->get();
        return view('kuliner.index', compact('kuliners'));
    }

    public function create()
    {
        return view('kuliner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $gambarPath = $request->file('gambar')->store('kuliners', 'public');

        Kuliner::create([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'],
            'harga' => $validated['harga'],
            'gambar' => $gambarPath
        ]);

        return redirect()->route('admin.kuliner.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit(Kuliner $kuliner)
    {
        return view('kuliner.edit', compact('kuliner'));
    }

    public function update(Request $request, Kuliner $kuliner)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($kuliner->gambar);
            $validated['gambar'] = $request->file('gambar')->store('kuliners', 'public');
        }

        $kuliner->update($validated);
        return redirect()->route('admin.kuliner.index')->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Kuliner $kuliner)
    {
        Storage::disk('public')->delete($kuliner->gambar);
        $kuliner->delete();
        return redirect()->route('admin.kuliner.index')->with('success', 'Menu berhasil dihapus');
    }

    public function rekomendasi()
    {
        // Ambil kuliner terlaris berdasarkan jumlah barang terjual (quantity)
        $kuliners = Kuliner::with(['ratings', 'orderItems.order.user'])
            ->withAvg('ratings', 'rating')
            ->withCount('orderItems')
            ->withSum('orderItems', 'quantity')
            ->where('tersedia', true)
            ->orderByDesc('order_items_sum_quantity')
            ->take(10)
            ->get();

        // Ambil user yang pernah membeli setiap kuliner
        foreach ($kuliners as $kuliner) {
            $userIds = $kuliner->orderItems->pluck('order.user_id')->unique();
            $kuliner->buyers = \App\Models\User::whereIn('id', $userIds)->get();
        }

        return view('kuliner.rekomendasi', compact('kuliners'));
    }
}