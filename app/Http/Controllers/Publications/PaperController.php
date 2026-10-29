<?php

namespace App\Http\Controllers\Publications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    /**
     * Display a listing of published papers.
     */
    public function index()
    {
        return view('publications.papers.index');
    }

    /**
     * Display the specified paper.
     */
    public function show($id)
    {
        return view('publications.papers.show', compact('id'));
    }

    /**
     * Search papers by keyword.
     */
    public function search(Request $request)
    {
        return view('publications.papers.search', ['query' => $request->get('q')]);
    }
}
