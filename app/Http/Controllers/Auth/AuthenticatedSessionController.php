<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Redirect otomatis berdasarkan role
        $user = $request->user();

        if ($user->hasRole(['Superadmin', 'Program Manager', 'Finance'])) {
            // Admin
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->hasRole('Donor')) {
            // Donor
            return redirect()->intended(route('donor.dashboard'));
        }

        // Default fallback, jika tidak punya role
        return redirect()->intended('/');
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
