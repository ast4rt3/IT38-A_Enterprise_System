<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

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
        try {
            // Attempt authentication
            if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }

            $user = Auth::user();
            
            // Store minimal data in session instead of cache
            $request->session()->put('user_role', $user->role);
            $request->session()->put('user_name', $user->first_name . ' ' . $user->last_name);

            // Regenerate session only if needed
            if (!$request->session()->has('auth.password_confirmed_at')) {
                $request->session()->regenerate();
            }

            // Redirect based on role
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'driver' => redirect()->route('driver.dashboard'),
                default => redirect()->route('user.dashboard'),
            };

        } catch (ValidationException $e) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => trans('auth.failed'),
                ]);
        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'An error occurred during login. Please try again.',
                ]);
        }
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
