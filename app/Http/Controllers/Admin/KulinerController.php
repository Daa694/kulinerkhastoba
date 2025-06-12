<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuliner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KulinerController extends Controller
{
    public function index()
    {
        $kuliners = Kuliner::latest()->get();
        return view('admin.kuliner.index', compact('kuliners'));
    }

    public function create()
    {
        return view('admin.kuliner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tersedia' => 'boolean'
        ]);

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('kuliners', 'public');
            $validated['gambar'] = $gambarPath;
        }

        $validated['tersedia'] = $request->has('tersedia');

        Kuliner::create($validated);
        return redirect()->route('admin.kuliner.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit(Kuliner $kuliner)
    {
        return view('admin.kuliner.edit', compact('kuliner'));
    }

    public function update(Request $request, Kuliner $kuliner)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tersedia' => 'boolean'
        ]);

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($kuliner->gambar) {
                Storage::disk('public')->delete($kuliner->gambar);
            }
            $gambarPath = $request->file('gambar')->store('kuliners', 'public');
            $validated['gambar'] = $gambarPath;
        }

        $validated['tersedia'] = $request->has('tersedia');

        $kuliner->update($validated);
        return redirect()->route('admin.kuliner.index')->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Kuliner $kuliner)
    {
        if ($kuliner->gambar) {
            Storage::disk('public')->delete($kuliner->gambar);
        }
        
        $kuliner->delete();
        return redirect()->route('admin.kuliner.index')->with('success', 'Menu berhasil dihapus');
    }
}
