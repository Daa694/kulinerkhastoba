<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kuliner;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['rekomendasi']);
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $produks = Produk::all();
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'detail' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('images/produk'), $nama_gambar);
            $data['gambar'] = 'produk/' . $nama_gambar;
        }

        Produk::create($data);
        return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'detail' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $produk = Produk::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                $old_path = public_path('images/' . $produk->gambar);
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }

            $gambar = $request->file('gambar');
            $nama_gambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('images/produk'), $nama_gambar);
            $data['gambar'] = 'produk/' . $nama_gambar;
        }

        $produk->update($data);
        return redirect()->route('dashboard')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        if ($produk->gambar) {
            $path = public_path('images/' . $produk->gambar);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $produk->delete();
        return redirect()->route('dashboard')->with('success', 'Produk berhasil dihapus!');
    }

    public function rekomendasi()
    {
        $kuliners = Kuliner::where('tersedia', true)
            ->with(['ratings' => function($query) {
                $query->with('user')->latest();
            }])
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('rekomendasi', compact('kuliners'));
    }
}