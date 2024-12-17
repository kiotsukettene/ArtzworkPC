<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Orders::paginate(10);
        return Inertia::render('AdminSide/Orders/Transactions', [
            'orders' => $orders,
        ]);
    }
}
