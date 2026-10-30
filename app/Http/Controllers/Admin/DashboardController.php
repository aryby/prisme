<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_papers' => Paper::count(),
            'total_users' => User::count(),
            'pending_reviews' => Review::where('status', 'pending')->count(),
            'accepted_papers' => Paper::where('status', 'accepted')->count(),
            'recent_papers' => Paper::latest()->take(5)->get(),
            'recent_users' => User::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
