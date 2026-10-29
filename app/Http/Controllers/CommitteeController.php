<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    /**
     * Display the committee page.
     */
    public function index()
    {
        return view('committee');
    }
}
