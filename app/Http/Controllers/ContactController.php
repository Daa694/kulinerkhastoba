<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class contactController extends Controller
{
    public function index()
    {
        return view('contact'); // Menampilkan file resources/views/menu.blade.php
    }
}

