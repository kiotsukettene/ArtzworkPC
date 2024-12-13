<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientLoginController extends Controller
{
    public function create() {
        return Inertia::render("Auth/Login");
    }

    public function store(Request $request) {
        $credentials = $request->validate([
            'email_address' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }
        // Check if email exists first
        $customer = \App\Models\Customer::where('email_address', $request->email_address)->first();

        if ($customer) {
            return back()->withErrors([
                'password' => 'The password is incorrect.'
            ])->onlyInput('password');
        }

        return back()->withErrors([
            'email_address' => 'The email address does not match our records.'
        ])->onlyInput('email_address');
    }

    public function destroy(Request $request) {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
