<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuliner;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Cek role user di session
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('login.form');
        }
        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa mengakses dashboard.');
        }
        $kuliners = DB::table('kuliners')
            ->leftJoin('ratings', 'kuliners.id', '=', 'ratings.kuliner_id')
            ->select(
                'kuliners.id',
                'kuliners.nama',
                'kuliners.harga',
                'kuliners.gambar_kuliner',
                'kuliners.detail',
                DB::raw('COALESCE(AVG(ratings.rating),0) as avg_rating'),
                DB::raw('COUNT(ratings.id) as total_rating')
            )
            ->groupBy('kuliners.id', 'kuliners.nama', 'kuliners.harga', 'kuliners.gambar_kuliner', 'kuliners.detail')
            ->get();
        return view('dashboard', compact('kuliners'));
    }
}
