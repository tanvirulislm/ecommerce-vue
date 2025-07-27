<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function Categorypage()
    {
        $category = Category::All();
        return Inertia::render('Category', [
            'category' => $category
        ]);
    }

    public function CreateCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Category::create($request->all());

        return redirect()->back()->with('success', 'Category created successfully.');
    }
}
