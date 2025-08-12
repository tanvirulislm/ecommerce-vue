<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function ProductPage()
    {
        $product = Product::with(['category', 'brand', 'variations'])
            ->get();
        return Inertia::render('Product', [
            'product' => $product,
        ]);
    }


    public function CreateProduct(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_des' => 'required|string|max:500',
            'long_des' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'boolean',
            'discount_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'stock' => 'required|integer|min:0',
            'remark' => 'required|in:Popular,New,Top,Special,Trending,Regular',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $image = null;
        $images = [];

        if ($request->hasFile('image')) {
            $cover = $request->file('image');
            $coverName = time() . '_cover.' . $cover->getClientOriginalExtension();
            $cover->move(public_path('uploads/products'), $coverName);
            $image = 'uploads/products/' . $coverName;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $img) {
                $imageName = time() . "_$key." . $img->getClientOriginalExtension();
                $img->move(public_path('uploads/products'), $imageName);
                $images[] = 'uploads/products/' . $imageName;
            }
        }
        Product::create([
            'title' => $request->input('title'),
            'short_des' => $request->input('short_des'),
            'long_des' => $request->input('long_des'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount', false),
            'discount_price' => $request->input('discount_price', 0),
            'image' => $image,
            'images' => json_encode($images),
            'stock' => $request->input('stock', 0),
            'remark' => $request->input('remark'),
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id')
        ]);

        return redirect()->back()->with('success', 'Product created successfully.');
    }

    public function CreateProductPage()
    {
        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();

        return Inertia::render('CreateProduct', [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
