<?php

namespace App\Http\Controllers\Client;

use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ProductListController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->select(['id', 'name', 'price', 'stock', 'brand_id', 'category_id', 'product_images'])
            ->with([
                'category:id,name',
                'brand:id,name',
            ])
            ->filter($request->only([
                'search',
                'priceRange',
                'inStock',
                'brands',
                'categories'
            ]));

        $products = $query->paginate(16);

        $products->getCollection()->transform(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'stock' => $product->stock,
                'brand' => $product->brand->name,
                'category' => $product->category->name,
                'image' => $product->product_images[0] ?? null,
                'rating' => 4
            ];
        });

        $categories = Cache::remember('categories', 3600, function () {
            return Category::select(['id', 'name'])
                ->withCount('products')
                ->get();
        });

        $brands = Cache::remember('brands', 3600, function () {
            return Brand::select(['id', 'name'])
                ->withCount('products')
                ->get();
        });

        return Inertia::render('ClientSide/ProductList', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'searchTerm' => $request->search,
            'filters' => $request->only(['priceRange', 'inStock', 'brands', 'categories'])
        ]);
    }
}
