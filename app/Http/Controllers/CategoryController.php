<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("AdminSide/Categories/Index", [
            'categories' => Category::paginate(5)
        ]);
    }


    public function create()
    {
        return Inertia::render("AdminSide/Categories/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'slug' => str()->slug($request->input('name')),
            'sku' => strtoupper( // Generate SKU
                preg_replace('/[aeiou\s]/i', '', $request->input('name'))
            )
        ]);

        // Limit SKU to first 3 characters
        $request->merge([
            'sku' => substr($request->input('sku'), 0, 3),
        ]);

        //Validate
        $categoryFields = $request->validate([
            'image' => ['nullable', 'file', 'max:10240'],
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'max:255', 'unique:categories'],
            'sku' => ['required', 'max:3', 'unique:categories'],
        ]);

        //Image

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('categoryImages', 'public');
            $categoryFields['image'] = $imagePath;
        }
        //Store
        Category::create($categoryFields);

        //Redirect
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render("AdminSide/Categories/Edit", [
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'sku' => $category->sku,
                'image' => $category->image ? asset('storage/' . $category->image) : asset('storage/categoryImages/default.jpg'), // Add full image URL or null
            ],
        ]);
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
