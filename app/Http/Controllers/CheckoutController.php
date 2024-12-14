<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\CustomerAddresses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get authenticated customer
        $customer = Auth::guard('customer')->user();
        $address = CustomerAddresses::where('customer_id', $customer->id)->first();
        // Get selected cart items
        $selectedItems = CartItem::where('customer_id', $customer->id)
            ->where('selected', true)
            ->with('product')
            ->get() 
            ->map(function ($item) {
                return [
                    'id' => $item->product_id,
                    'name' => $item->product->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'image' => $item->product->product_images[0] ?? null,
                    'subtotal' => $item->price * $item->quantity
                ];
            });

        // Calculate totals
        $subtotal = $selectedItems->sum('subtotal');
        $shipping = 0; // You can modify this based on your shipping logic
        $total = $subtotal + $shipping;

        return Inertia::render('ClientSide/Customer/Checkout', [
            'customer' => [
                'id' => $customer->id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'address' => $address,
            ],
            'items' => $selectedItems,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total
            ],
            
        ]);
    }

    public function store(Request $request)
    {
        // Handle the form submission
    }
}
