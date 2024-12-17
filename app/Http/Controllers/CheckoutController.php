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

    public function pay(Request $request)
    {
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

        $data = [
            'data' => [
                'attributes' => [
                    'amount' => $total * 100,
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

        // Store the session ID and redirect URL
        Session::put('payment_data', [
            'response_id' => $response->data->id,
            'selected_items' => $selectedItems,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total,
            'payment_method' => 'gcash',
            'customer' => $customer
            
        ]);

        return redirect($response->data->attributes->redirect->checkout_url);
    }

    public function store()
    {
        $paymentData = Session::get('payment_data');

        if (!$paymentData) {
            return redirect()->route('customer.checkout')->withErrors(['error' => 'Payment session expired.']);
        }

        // Create the order only after successful payment
        $order = Orders::create([
            'reference_number' => 'ORD-' . uniqid(),
            'customer_id' => $paymentData['customer']->id,
            'total_amount' => $paymentData['total'],
            'payment_method' => $paymentData['payment_method'],
            'shipping_method' => 'delivery', // Modify based on your requirements
            'shipping_amount' => $paymentData['shipping'],
            'notes' => null // Modify based on your requirements
        ]);

        // Create order items
        foreach ($paymentData['selected_items'] as $item) {
            OrderItems::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_amount' => $item['price'],
                'total_amount' => $item['subtotal']
            ]);
        }

        // Clear selected cart items
        CartItem::where('customer_id', $paymentData['customer']->id)
            ->where('selected', true)
            ->delete();

        Session::forget('payment_data');

        return Inertia::render('ClientSide/Customer/PaymentSuccess', [
            'message' => 'Payment successful!',
            'order' => $order
        ]);
    }

    public function success()
    {
        return Inertia::render('ClientSide/Customer/PaymentSuccess', [
            'message' => 'Payment successful!',
        ]);
    }
}
