<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function Categorypage()
    {
        $categories = Category::All();
        return Inertia::render('Category', [
            'categories' => $categories
        ]);
    }

    public function CreateCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $imageName);
            $image = 'uploads/categories/' . $imageName;
        }

        Category::create([
            'name' => $request->input('name'),
            'image' => $image,
            'parent_id' => $request->input('parent_id')
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
    }
}
