<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuliner;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function profil()
    {
        return view('profil');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function menu()
    {
        $kuliners = Kuliner::all();
        return view('menu', compact('kuliners'));
    }    public function produk()
    {        $recommendedProducts = Kuliner::with(['ratings'])
            ->withAvg('ratings', 'rating')
            ->having('ratings_avg_rating', '>=', 4)
            ->orWhereNull('ratings_avg_rating')
            ->orderByDesc('ratings_avg_rating')
            ->paginate(12);
        return view('produk_list', compact('recommendedProducts'));
    }

    public function produkDetail($id)
    {
        $product = Kuliner::findOrFail($id);
        return view('produk.detail', compact('product'));
    }

    public function keranjang()
    {
        return view('keranjang');
    }    public function cart()
    {
        return view('cart');
    }

    public function detail()
    {
        return view('detail');
    }

    public function detailKuliner($id)
    {
        $kuliner = Kuliner::findOrFail($id);
        return view('detail_kuliner', compact('kuliner'));
    }
}