<?php

namespace App\Http\Controllers\Client;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $transformedCart = [];
        foreach ($cart as $productId => $item) {
            $transformedCart[$productId] = [
                $productId,           // [0] id
                $item['name'],        // [1] name
                $item['price'],       // [2] price
                $item['quantity'],    // [3] quantity
                $item['image'],       // [4] image
                $item['selected'],    // [5] selected
            ];
        }

        return Inertia::render('ClientSide/Cart', [
            'cart' => $transformedCart
        ]);
    }

    public function addToCart(Request $request)
    {
        $cart = Session::get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->quantity;
        } else {
            $cart[$productId] = [
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'image' => $request->image,
                'selected' => true
            ];
        }

        Session::put('cart', $cart);
        return back()->with('success', 'Product added to cart successfully');
    }

    public function updateQuantity(Request $request)
    {
        $cart = Session::get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            return back()->with('success', 'Quantity updated successfully');
        }

        return back()->with('error', 'Product not found in cart');
    }

    public function removeFromCart(Request $request)
    {
        $cart = Session::get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            return back()->with('success', 'Product removed from cart successfully');
        }

        return back()->with('error', 'Product not found in cart');
    }

    public function updateSelection(Request $request)
    {
        $cart = Session::get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $cart[$productId]['selected'] = $request->selected;
            Session::put('cart', $cart);
            return back()->with('success', 'Selection updated successfully');
        }

        return back()->with('error', 'Product not found in cart');
    }

    public function updateAllSelections(Request $request)
    {
        $cart = Session::get('cart', []);

        foreach ($cart as $productId => $item) {
            $cart[$productId]['selected'] = $request->selected;
        }

        Session::put('cart', $cart);
        return back()->with('success', 'All selections updated successfully');
    }

    public function clearCart()
    {
        Session::forget('cart');
        return back()->with('success', 'Cart cleared successfully');
    }
}
