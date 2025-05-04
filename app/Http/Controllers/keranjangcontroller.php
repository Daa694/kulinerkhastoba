<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        return view('keranjang'); // Pastikan ada file keranjang.blade.php di resources/views
    }
}
