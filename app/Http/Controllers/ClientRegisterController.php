<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class ClientRegisterController extends Controller
{
    public function create() {
        return Inertia::render("Auth/Register");
    }

    public function show() {
        return Inertia::render("ClientSide/Customer/RegisterProcess", [
            'customer' => Auth::guard('customer')->user()
        ]);
    }

    public function store(Request $request) {
        $credentials = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email_address' => 'required|lowercase|email|unique:customers,email_address',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email_address' => $request->email_address,
            'password' => $request->password,
        ]);

        event(new Registered($user));

        Auth::guard('customer')->login($user);

        return redirect()->route('verification.notice');
    }
}
