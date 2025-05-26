<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $kuliners = \App\Models\Kuliner::all();
        return view('menu', compact('kuliners'));
    }
}
