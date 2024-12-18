<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderDetailsController extends Controller
{
    public function show($reference_number)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('customer.login');
        }

        $order = Orders::where('reference_number', $reference_number)
            ->where('customer_id', $customer->id)
            ->with(['items.product'])
            ->firstOrFail();

        $orderData = [
            'id' => $order->id,
            'reference_number' => $order->reference_number,
            'status' => $order->order_status,
            'order_date' => $order->created_at->format('Y-m-d'),
            'payment_method' => $order->payment_method,
            'e_invoice' => $order->e_invoice,
            'shipping_fee' => $order->shipping_fee,
            'total_amount' => $order->total_amount,
            'subtotal' => $order->total_amount - $order->shipping_fee,
            'shipping_info' => [
                'name' => $order->customer->first_name . ' '. $order->customer->last_name,
                'address' => $order->shipping_address,
                'phone' => $order->customer->phone,
            ],
            'items' => $order->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->product->name,
                    'image' => $item->product->product_images[0] ?? null,
                    'sku' => $item->product->sku,
                    'category' => $item->product->category->name,
                    'brand' => $item->product->brand->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_amount,
                    'total' => $item->quantity * $item->unit_amount,
                ];
            }),
        ];

        return Inertia::render('ClientSide/Customer/OrderDetails', [
            'order' => $orderData,
            'customer' => $customer,
        ]);
    }
}
