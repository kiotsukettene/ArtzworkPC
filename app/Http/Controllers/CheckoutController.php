<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Orders;
use App\Models\CartItem;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Models\CustomerAddresses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $shipping = 145; // You can modify this based on your shipping logic
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
    $customer = Auth::guard('customer')->user();

    // Create the order
    $order = Orders::create([
        'reference_number' => 'ORD-' . uniqid(),
        'customer_id' => $customer->id,
        'total_amount' => $request->summary['total'],
        'payment_method' => $request->payment_method,
        'shipping_method' => $request->delivery_method,
        'pickup_date_time' => $request->delivery_method === 'pickup' ?
            $request->pickup_date . ' ' . $request->pickup_time : null,
        'shipping_amount' => $request->summary['shipping'],
        'notes' => $request->notes
    ]);

    // Create order items
    foreach ($request->items as $item) {
        OrderItems::create([
            'order_id' => $order->id,
            'product_id' => $item['id'],
            'quantity' => $item['quantity'],
            'unit_amount' => $item['price'],
            'total_amount' => $item['price'] * $item['quantity']
        ]);
    }

    // Clear selected cart items
    CartItem::where('customer_id', $customer->id)
        ->where('selected', true)
        ->delete();

    return to_route('customer.payment', ['order_id' => $order->id]);
}

public function pay(Request $request)
{
    $order = Orders::with(['items.product', 'customer'])->findOrFail($request->order_id);
    $customer = Auth::guard('customer')->user();
    $address = CustomerAddresses::where('customer_id', $customer->id)->first();

    $data = [
        'data' => [
            'attributes' => [
                'amount' => $order->total_amount * 100,
                'currency' => 'PHP',
                'type' => 'gcash',
                'redirect' => [
                    'success' => route('customer.payment.success'),
                    'failed' => route('customer.checkout'),
                ],
                'billing' => [
                    'name' => $customer->first_name . ' ' . $customer->last_name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'address' => [
                        'line1' => $address->complete_address,
                        'city' => $address->city,
                        'state' => $address->state,
                        'postal_code' => $address->zip_code,
                    ]
                ]
            ]
        ]
    ];

    $response = Curl::to('https://api.paymongo.com/v1/sources')
        ->withHeader('Content-Type: application/json')
        ->withHeader('Accept: application/json')
        ->withHeader('Authorization: Basic ' . base64_encode(env('AUTH_PAY') . ':'))
        ->withData($data)
        ->asJson()
        ->post();

    if (isset($response->errors)) {
        return redirect()->back()->withErrors(['error' => 'Payment processing failed.']);
    }

    // Store the session ID
    Session::put('session_id', $response->data->id);

    // Access the checkout URL correctly from the response object
    $checkoutUrl = $response->data->attributes->redirect->checkout_url;

    return Inertia::render('ClientSide/Customer/Payment', [
        'checkoutUrl' => $checkoutUrl,
        'order' => $order
    ]);
}

    public function success()
    {
        $session_id = Session::get('session_id');

        $order = Orders::where('reference_number', $session_id)->first();

        if ($order) {
            $order->update(['payment_status' => 'paid']);
        }

        return Inertia::render('ClientSide/Customer/PaymentSuccess', [
            'message' => 'Payment successful!',
            'order' => $order
        ]);
    }
}
