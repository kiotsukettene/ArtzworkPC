<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class ClientRegisterController extends Controller
{
    public function create() {
        return Inertia::render("Auth/Register");
    }

    public function store(Request $request) {

    }
}
