<?php

namespace App\Http\Controllers\UiController\Auth;

use App\Http\Controllers\Controller;
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
    public function store(Request $request): RedirectResponse
    {
        $apiRequest = Request::create('/api/login', 'POST', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        $response = app()->handle($apiRequest);

        if ($response->getStatusCode() !== 200) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
        }

        $data = json_decode($response->getContent(), true);
        Auth::guard('web')->loginUsingId($data['user']['id']);

        session(['api_token' => $data['access_token']]);

        return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
    }

    public function logout(Request $request): RedirectResponse
    {
        $token = session('api_token');

        if ($token) {
            $apiRequest = Request::create('/api/logout', 'POST', [], [], [], [
                'HTTP_Authorization' => 'Bearer ' . $token,
            ]);

            app()->handle($apiRequest);
        }

        Auth::guard('web')->logout();
        $request->session()->forget('api_token');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully!');
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
