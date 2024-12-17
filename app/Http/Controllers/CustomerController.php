<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(10);
        return Inertia::render('AdminSide/Customers/Index', [
            'customers' => $customers,
        ]);
    }
}
