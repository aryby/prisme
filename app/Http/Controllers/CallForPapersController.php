<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CallForPapersController extends Controller
{
    /**
     * Display the call for papers page.
     */
    public function index()
    {
        return view('call-for-papers');
    }
}
