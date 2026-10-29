<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectToTarget(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectToTarget(Auth::user());
        }

        return back()
            ->withErrors([
                'email' => 'These credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    protected function redirectToTarget($user)
    {
        if (! $user) {
            return redirect()->intended('/');
        }

        if ($user->isAdmin()) {
            return redirect()->intended($this->panelRoute('admin', '/admin'));
        }

        if ($user->isAuthor()) {
            return redirect()->intended($this->panelRoute('author', '/author/dashboard'));
        }

        return redirect()->intended('/');
    }

    protected function panelRoute(string $panelId, string $fallback): string
    {
        try {
            return route('filament.' . $panelId . '.pages.dashboard');
        } catch (\Throwable $e) {
            return $fallback;
        }
    }
}
