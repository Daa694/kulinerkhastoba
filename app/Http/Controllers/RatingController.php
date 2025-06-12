<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Kuliner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Kuliner $kuliner)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500'
        ]);

        // Check if user has already rated this kuliner
        $existingRating = Rating::where('user_id', Auth::id())
            ->where('kuliner_id', $kuliner->id)
            ->first();

        if ($existingRating) {
            // Update existing rating
            $existingRating->rating = $validated['rating'];
            $existingRating->komentar = $validated['komentar'];
            $existingRating->save();
            
            $message = 'Rating berhasil diperbarui!';
        } else {
            // Create new rating
            Rating::create([
                'kuliner_id' => $kuliner->id,
                'user_id' => Auth::id(),
                'rating' => $validated['rating'],
                'komentar' => $validated['komentar']
            ]);
            
            $message = 'Terima kasih atas penilaian Anda!';
        }

        return redirect()->back()->with('success', $message);
    }

    public function update(Request $request, Rating $rating)
    {
        // Verify user ownership
        if ($rating->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500'
        ]);

        $rating->update($validated);

        return redirect()->back()->with('success', 'Rating berhasil diperbarui!');
    }

    public function destroy(Rating $rating)
    {
        // Verify user ownership
        if ($rating->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $rating->delete();

        return redirect()->back()->with('success', 'Rating berhasil dihapus!');
    }
}
