<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use Illuminate\Http\Request;

class MenuController extends Controller
{    
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort');
        $query = Kuliner::where('tersedia', true)
                       ->withAvg('ratings', 'rating')
                       ->with(['ratings' => function($query) {
                           $query->with('user')->latest();
                       }])
                       ->where('stok', '>', 0);
        
        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        // Sorting logic
        if ($sort === 'harga_asc') {
            $query->orderBy('harga', 'asc');
        } elseif ($sort === 'harga_desc') {
            $query->orderBy('harga', 'desc');
        } elseif ($sort === 'rating_desc') {
            $query->orderByDesc('ratings_avg_rating');
        } elseif ($sort === 'terbaru') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        // Get 3 highest rated menu items (populer)
        $topRatedKuliners = Kuliner::where('tersedia', true)
            ->where('stok', '>', 0)
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->take(3)
            ->get();

        $kuliners = $query->get();
        return view('menu', compact('kuliners', 'search', 'topRatedKuliners', 'sort'));
    }

    public function show(Kuliner $kuliner)
    {
        $kuliner->load(['ratings' => function($query) {
            $query->with('user')->latest();
        }]);
        
        return view('detail', compact('kuliner'));
    }

    public function rate(Request $request, Kuliner $kuliner)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'nullable|string|max:255',
        ]);
        $kuliner->ratings()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );
        // Update avg rating (otomatis by withAvg)
        return redirect()->route('menu')->with('success', 'Terima kasih atas rating Anda!');
    }
}
