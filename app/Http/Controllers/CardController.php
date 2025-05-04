<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function cart()
    {
        return view('card'); // atau cart, tergantung file view-nya
    }
}
