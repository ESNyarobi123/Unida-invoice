<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    protected array $users = [
        'info@unida.tech' => 'Unida@2025',
        'ezekielsalehe00@gmail.com' => 'ESNyarobi@1234',
    ];

    public function showLogin(Request $request): View
    {
        if ($request->session()->has('user')) {
            return view('auth.login', ['redirect' => true]);
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email = strtolower($credentials['email']);
        $password = $credentials['password'];

        if (isset($this->users[$email]) && hash_equals($this->users[$email], $password)) {
            $request->session()->regenerate();
            $request->session()->put('user', ['email' => $email]);

            return redirect()->route('invoice.builder');
        }

        return back()->withErrors([
            'email' => 'Email au nenosiri si sahihi. Tafadhali jaribu tena.',
        ])->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

