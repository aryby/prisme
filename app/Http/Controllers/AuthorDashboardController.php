<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $registration = $user->registration;
        $papers = $user->papers()->latest()->get();
        
        $stats = [
            'total_papers' => $papers->count(),
            'submitted_papers' => $papers->where('status', 'submitted')->count(),
            'under_review' => $papers->where('status', 'under_review')->count(),
            'accepted_papers' => $papers->where('status', 'accepted')->count(),
            'rejected_papers' => $papers->where('status', 'rejected')->count(),
        ];

        return view('author.dashboard', compact('registration', 'papers', 'stats'));
    }

    public function showPaper(Paper $paper)
    {
        $paper = Paper::with('reviews.reviewer')->findOrFail($paper->id);

        return view('author.papers.show', compact('paper'));
    }

    public function createPaper()
    {
        // Check if user account is active
        if (!Auth::user()->isActive()) {
            return redirect()->route('author.dashboard')
                ->with('error', 'Your account is not active. You cannot submit papers until it is activated by an administrator.');
        }

        return view('author.papers.create');
    }

    public function storePaper(Request $request)
    {
        // Check if user account is active
        if (!Auth::user()->isActive()) {
            return redirect()->route('author.dashboard')
                ->with('error', 'Your account is not active. You cannot submit papers until it is activated by an administrator.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'track' => 'required|string|max:255',
            'paper_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        // Handle file upload
        $paperPath = null;
        if ($request->hasFile('paper_file')) {
            $paperPath = $request->file('paper_file')->store('papers', 'public');
        }

        Paper::create([
            'author_id' => Auth::id(),
            'title' => $request->title,
            'abstract' => $request->abstract,
            'keywords' => $request->keywords,
            'track' => $request->track,
            'status' => 'under_review', // Default status
            'file_path' => $paperPath,
            'submitted_at' => now(),
        ]);

        return redirect()->route('author.dashboard')
            ->with('success', 'Paper submitted successfully! It is now under review.');
    }

    public function indexPapers()
    {
        $papers = Auth::user()->papers()->latest()->get();
        return view('author.papers.index', compact('papers'));
    }
}
