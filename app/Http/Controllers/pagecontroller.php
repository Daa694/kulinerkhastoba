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
    }

    public function produk()
    {
        $kuliners = Kuliner::all();
        return view('produk_list', compact('kuliners'));
    }

    public function keranjang()
    {
        return view('keranjang');
    }

    public function card()
    {
        return view('card');
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