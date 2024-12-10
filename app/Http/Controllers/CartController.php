<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        return Inertia::render('ClientSide/Cart', [
            'cartItems' => $cartItems
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|string',
        ]);

        $cartItems = session()->get('cart', []);
        $productId = $request->product_id;

        if (isset($cartItems[$productId])) {
            $cartItems[$productId][3] += $request->quantity;
        } else {
            $cartItems[$productId] = [
                $request->product_id,  // 0: id
                $request->name,        // 1: name
                $request->price,       // 2: price
                $request->quantity,    // 3: quantity
                $request->image,       // 4: image
                false,                 // 5: selected
            ];
        }

        session()->put('cart', $cartItems);
        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItems = session()->get('cart', []);
        $productId = $request->product_id;

        if (isset($cartItems[$productId])) {
            $cartItems[$productId][3] = $request->quantity;
            session()->put('cart', $cartItems);
            return back()->with('success', 'Cart updated');
        }

        return back()->with('error', 'Product not found');
    }

    public function removeFromCart(Request $request)
    {
        $productId = $request->product_id;
        $cartItems = session()->get('cart', []);

        if (isset($cartItems[$productId])) {
            unset($cartItems[$productId]);
            session()->put('cart', $cartItems);
        }

        return redirect()->back();
    }

    public function updateSelection(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'selected' => 'required|boolean',
        ]);

        $cartItems = session()->get('cart', []);
        $productId = $request->product_id;

        if (isset($cartItems[$productId])) {
            $cartItems[$productId][5] = $request->selected;
            session()->put('cart', $cartItems);
        }

        return redirect()->back();
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back();
    }

    public function updateAllSelections(Request $request)
    {
        $request->validate([
            'selected' => 'required|boolean',
        ]);

        $cartItems = session()->get('cart', []);

        // Update all items' selection state
        foreach ($cartItems as $productId => $item) {
            $cartItems[$productId][5] = $request->selected;
        }

        session()->put('cart', $cartItems);
        return redirect()->back();
    }

    public function getCartCount()
    {
        $cartItems = session()->get('cart', []);
        return count($cartItems);
    }

    // Update the constructor to share cart count with all views
    public function __construct()
    {
        $cartCount = $this->getCartCount();
        Inertia::share('cartCount', $cartCount);
    }
}
