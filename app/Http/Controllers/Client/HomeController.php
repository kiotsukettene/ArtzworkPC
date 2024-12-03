<?php

namespace App\Http\Controllers\Client;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $products = Product::with(['category', 'brand', 'specifications'])->get();
        $exploreProducts = Product::with(['category', 'brand', 'specifications'])->take(15)->get()->random(15);
        $latestProducts = Product::with(['category', 'brand', 'specifications'])
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand->name,
                    'category' => $product->category->name,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'image' => $product->product_images[0] ?? null,
                    'specifications' => $product->specifications
                        ->map(fn($spec) => [
                            'name' => $spec->name,
                            'value' => $spec->pivot->value
                        ])
                ];
            });

        return Inertia::render('ClientSide/GuestHome', [
            'products' => $products,
            'exploreProducts' => $exploreProducts,
            'latestProducts' => $latestProducts,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }
}
