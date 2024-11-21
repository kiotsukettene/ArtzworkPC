<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class CategoryController extends Controller
{
    public function create(Request $request) {

        // Automatically generate slug and SKU based on the name field
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
        return redirect()->route('categoryview.index');
    }

    public function edit($id) {
        $category = Category::findorFail($id);

        return inertia('CategoryEdit',[
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id){

        // Automatically generate slug and SKU based on the name field
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
        $request->validate([
            'image' => ['nullable', 'file', 'max:10240'], // Max 10MB
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'max:255', Rule::unique('categories')->ignore($id)],
            'sku' => ['required', 'max:3', Rule::unique('categories')->ignore($id)],
        ]);
        //FindorFail
        $category = Category::findOrFail($id);


        //Update
        $category->update($request->all());
        //Redirect

        return redirect()->route('CategoryView.vue');
    }
}
