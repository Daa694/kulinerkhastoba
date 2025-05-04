<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index()
    {
        return view('detail'); // Menampilkan file resources/views/menu.blade.php
    }
    public function show($id)
{
    $kuliner = \App\Models\Kuliner::findOrFail($id);
    return view('detail_kuliner', compact('kuliner'));
}

}

