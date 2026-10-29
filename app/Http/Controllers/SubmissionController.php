<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\SubmissionConfirmation;

class SubmissionController extends Controller
{
    /**
     * Display the submission page.
     */
    public function index()
    {
        return view('submission');
    }

    /**
     * Handle an incoming paper submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'submission_option' => 'required|string|in:full_submission,abstract_submission',
            'title' => 'required|string|max:255',
            'track' => 'required|string|max:255',
            'abstract' => 'required|string',
            'keywords' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'affiliation' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:pdf|max:10240', // Max 10MB PDF
            'originality' => 'required|accepted',
            'copyright' => 'required|accepted',
            'attendance' => 'required|accepted',
        ]);

        // Find or create user
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make($randomPassword = Str::random(10)),
                'is_active' => false, // Account not active
                'role' => 'author',
            ]
        );

        // If user was just created, send email with password
        if ($user->wasRecentlyCreated) {
            Mail::to($user->email)->send(new SubmissionConfirmation($user, $randomPassword));
        }

        // Handle file upload
        $filePath = $request->file('file')->store('papers', 'public');

        // Create paper submission
        $paper = Paper::create([
            'author_id' => $user->id,
            'title' => $request->title,
            'abstract' => $request->abstract,
            'keywords' => $request->keywords,
            'track' => $request->track,
            'submission_option' => $request->submission_option,
            'affiliation' => $request->affiliation,
            'country' => $request->country,
            'phone' => $request->phone,
            'file_path' => $filePath,
            'status' => 'under_review',
            'submitted_at' => now(),
        ]);

        // Log in the user and redirect to the author dashboard
        Auth::login($user);

        return redirect()->route('author.dashboard')->with('status', 'Paper submitted successfully and is under review. Your account is not yet active. Please check your email for login details.');
    }
}
