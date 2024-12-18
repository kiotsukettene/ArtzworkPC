<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Orders;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Models\CustomerAddresses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Orders::latest()->paginate(10);
        return Inertia::render('AdminSide/Orders/Transactions', [
            'orders' => $orders,
        ]);
    }

    public function show()
    {


        $order = Orders::latest()
        ->paginate(9)
        ->through(function ($order) {
            return [
                'id' => $order->id,
                'customer_name' => $order->customer->first_name . ' ' . $order->customer->last_name,
                'customer_address' => $order->customer->default_address_id,
                'created_at' => $order->created_at->format('m/d/Y'),
                'total_amount' => $order->total_amount,
                'order_status' => $order->order_status,
                'customer_id' => $order->customer_id,
                'customer_phone_number' => $order->customer->phone,
                'reference_number' => $order->reference_number,
                'payment_method' => $order->payment_method,
                'payment_status' => $order->payment_status,
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_name' => $item->product->name ?? 'Unknown Product',
                        'category_id'  => $item->product->category_id ?? 'Unknown Category',
                        'brand_id' => $item->product->brand_id ?? 'Unknown Brand',
                        'product_image' => $item->product->product_images[0] ?? null,
                        'sku' => $item->product->sku ?? 'N/A',
                        'quantity' => $item->quantity,
                        'unit_amount' => $item->unit_amount,
                    ];
                }),
            ];
        });

        // $orders = Orders::where('customer_id', $customer->id)
        //     ->with(['items.product']) // Proper eager loading
        //     ->get()
        //     ->map(function ($order) {
        //         return [
        //             'id' => $order->id,
        //             'reference_number' => $order->reference_number,
        //             'status' => $order->order_status,
        //             'order_date' => $order->created_at->format('Y-m-d'),
        //             'total_amount' => $order->total_amount,
        //             'items' => $order->items->map(function ($item) {
        //                 return [
        //                     'product_name' => $item->product->name ?? 'Unknown Product',
        //                     'category_id'  => $item->product->category_id ?? 'Unknown Category',
        //                     'brand_id' => $item->product->brand_id ?? 'Unknown Brand',
        //                     'product_image' => $item->product->product_images[0] ?? null,
        //                     'sku' => $item->product->sku ?? 'N/A',
        //                     'quantity' => $item->quantity,
        //                     'unit_amount' => $item->unit_amount,
        //                 ];
        //             }),
        //         ];
        //     });


        return Inertia::render('AdminSide/Orders/OrderHistory', [
            'order' => $order,
        ]);
    }

    // public function accept(Request $request, $id)
    // {
    //     $order = Orders::find($id);
    //     $order->status = 'processing';
    //     $order->save();
    //     return back()->with('success', 'Order accepted successfully');
    // }
}
