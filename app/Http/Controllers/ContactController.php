<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:10000'],
        ]);

        ContactMessage::create($validated);

        return redirect()
            ->route('contact')
            ->with('contact_status', 'Thank you. Your message has been sent to the organizing committee.');
    }
}
