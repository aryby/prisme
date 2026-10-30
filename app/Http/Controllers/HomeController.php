<?php

namespace App\Http\Controllers;

use App\Models\Slide;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        return view('home', [
            'slides' => Slide::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
