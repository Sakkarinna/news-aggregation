<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.all_categories', compact('categories'));
    }

    public function create()
    {
        return view('categories.create_category');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->only(['name', 'description']));

        return view('categories.create_category')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit_category', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->only(['name', 'description']));

        return view('categories.all_categories')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return view('categories.all_categories')->with('success', 'Category deleted successfully.');
    }
}
