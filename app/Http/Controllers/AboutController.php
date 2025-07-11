<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = \App\Models\About::first();
        $aboutContent = $about ? $about->content : '';
        return view('about', compact('aboutContent'));
    }

    public function edit()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403);
        }
        $about = \App\Models\About::first();
        $aboutContent = $about ? $about->content : '';
        return view('about_edit', compact('aboutContent'));
    }

    public function update(Request $request)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403);
        }
        $request->validate([
            'about_content' => 'required|string',
        ]);
        $about = \App\Models\About::first();
        if (!$about) {
            $about = new \App\Models\About();
        }
        $about->content = $request->about_content;
        $about->save();
        return redirect()->route('contact')->with('success', 'Tentang Kami berhasil diperbarui.');
    }
}
