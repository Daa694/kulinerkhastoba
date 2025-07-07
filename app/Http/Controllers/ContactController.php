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
        ]);
        $contact = Contact::first();
        if (!$contact) {
            $contact = Contact::create($data);
        } else {
            $contact->update($data);
        }
        return redirect()->route('contact.edit')->with('success', 'Kontak berhasil diperbarui!');
    }
}
