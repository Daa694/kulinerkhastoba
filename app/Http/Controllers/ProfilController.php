<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        $pesanan = Order::where('user_id', $user->id)
            ->with('orderItems.kuliner')
            ->latest()
            ->get();

        return view('profil', [
            'user' => $user,
            'pesanan' => $pesanan,
            'alamat' => $user->alamat_pengiriman
        ]);
    }
    
    public function updateAlamat(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string|max:255'
        ]);

        $user = Auth::user();
        $user->alamat_pengiriman = $request->alamat_pengiriman;
        $user->save();

        return redirect()
            ->route('profil.index')
            ->with('success', 'Alamat pengiriman berhasil diperbarui');
    }
}
