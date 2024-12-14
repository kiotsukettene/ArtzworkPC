<?php

namespace App\Http\Controllers\Client;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientProfileController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $addresses = $customer->addresses;
        $defaultAddress = $addresses->where('id', $customer->default_address_id)->first();
        return Inertia::render('ClientSide/Customer/Profile', [
            'customer' => $customer,
            'addresses' => $addresses,
            'defaultAddress' => $defaultAddress,
        ]);
    }
}
