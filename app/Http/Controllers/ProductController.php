<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::with(['category', 'brand'])->paginate(5);
        return Inertia::render('AdminSide/Products/Index', [
            'products'=> $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('AdminSide/Products/Create', [
            'categories' => Category::with('specifications')->get(),
            'brands' => Brand::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:products',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
        'warranty' => 'nullable|string|max:255',
        'images.*' => 'nullable|file|image|max:10240', // Max size: 10MB
        'specifications' => 'nullable|array', // Specifications as an array
        'specifications.*.id' => 'nullable|integer|exists:specifications,id',
        'specifications.*.value' => 'nullable|string|max:255',
    ]);

    try {
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('product_images', 'public');
            }
        }

        // Save the product without SKU initially
        $product = Product::create(array_merge($validated, [
            'product_images' => $images, // Store the image paths in JSON
            'sku' => '', // Placeholder SKU; it will be updated after the product is created
        ]));

        // Generate the SKU based on category SKU and product ID
        $category = Category::find($validated['category_id']);
        $product->update([
            'sku' => $category->sku . '-' . $product->id,
        ]);

        // Attach specifications with values
        if (!empty($validated['specifications'])) {
            foreach ($validated['specifications'] as $spec) {
                $product->specifications()->attach($spec['id'], ['value' => $spec['value']]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    catch(\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
    // Handle file uploads for images

}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
