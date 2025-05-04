<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        return view('produk_list'); // Pastikan ada file resources/views/produk_list.blade.php
    }
}
