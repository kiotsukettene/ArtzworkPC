<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompareProductsController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();
    
        // Get category and brand filters from the request
        $categoryId = $request->get('category_id');
        $brandId = $request->get('brand_id');
    
        // Query products based on filters
        $query = Product::with(['category', 'brand', 'specifications']);
    
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
    
        if ($brandId) {
            $query->where('brand_id', $brandId);
        }
    
        $products = $query->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'brand' => $product->brand->name,
                'category' => $product->category->name,
                'price' => $product->price,
                'stock' => $product->stock,
                'image' => $product->product_images[0] ?? null,
                'specifications' => $product->specifications,
            ];
        });
    
        return Inertia::render('ClientSide/CompareProducts', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
    
}
