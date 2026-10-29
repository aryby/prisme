<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAuthorUser
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || ! Auth::user()->isAuthor()) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
