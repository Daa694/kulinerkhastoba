<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::first();
        return view('contact', compact('contact'));
    }

    public function edit()
    {
        $contact = Contact::first();
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403);
        }
        return view('contact_edit', compact('contact'));
    }

    public function update(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403);
        }
        $data = $request->validate([
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string',
            'email' => 'nullable|email',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',
            'website' => 'nullable|string',
            'about_content' => 'nullable|string',
        ]);
        $contact = Contact::first();
        if (!$contact) {
            $contact = Contact::create($data);
        } else {
            $contact->update($data);
        }
        // Update About
        if (isset($data['about_content'])) {
            $about = \App\Models\About::first();
            if (!$about) {
                $about = new \App\Models\About();
            }
            $about->content = $data['about_content'];
            $about->save();
        }
        return redirect()->route('contact.edit')->with('success', 'Kontak & Tentang Kami berhasil diperbarui!');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);
        $userId = auth()->check() ? auth()->id() : null;
        \App\Models\ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'user_id' => $userId,
        ]);
        return redirect()->route('contact')->with('success', 'Pesan Anda berhasil dikirim!');
    }
}
