<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use Illuminate\Http\Request;

class MenuController extends Controller
{    
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Kuliner::where('tersedia', true)
                       ->withAvg('ratings', 'rating')
                       ->with(['ratings' => function($query) {
                           $query->with('user')->latest();
                       }])
                       ->where('stok', '>', 0)
                       ->orderBy('created_at', 'desc');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }
        
        // Get the highest rated menu item
        $topRatedKuliner = Kuliner::where('tersedia', true)
            ->where('stok', '>', 0)
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->first();
        
        $kuliners = $query->get();
        return view('menu', compact('kuliners', 'search', 'topRatedKuliner'));
    }

    public function show(Kuliner $kuliner)
    {
        $kuliner->load(['ratings' => function($query) {
            $query->with('user')->latest();
        }]);
        
        return view('detail', compact('kuliner'));
    }
}
