<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function ProductPage()
    {
        $product = Product::with(['category', 'brand', 'variations', 'variations.options', 'variations.images'])
            ->get();
        return Inertia::render('Product', [
            'product' => $product,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'cover_image' => 'nullable|image|max:5048',
            'weight' => 'nullable|numeric',
            'barcode' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:active,draft,archived',
            'variations' => 'required|array',
            'variations.*.price' => 'required|numeric|min:0',
            'variations.*.stock' => 'required|integer|min:0',
            'variations.*.sku' => 'nullable|string|max:255',
            'variations.*.attributes' => 'nullable|array',
            'variations.*.images' => 'nullable|array',
            'variations.*.images.*' => 'nullable|image|max:5048',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::create([
                'title' => $request->title,
                'short_des' => $request->short_des,
                'long_des' => $request->long_des,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'remark' => $request->remark ?? null,
                'cover_image' => $request->file('cover_image')?->store('images/products', 'public'),
                'weight' => $request->weight,
                'barcode' => $request->barcode,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'status' => $request->status,
            ]);

            $variationsData = $request->input('variations', []);

            foreach ($variationsData as $index => $var) {
                $variation = $product->variations()->create([
                    'sku' => $var['sku'] ?? null,
                    'price' => $var['price'],
                    'discount_price' => $var['discount_price'] ?? null,
                    'stock' => $var['stock'],
                ]);


                if (!empty($var['attributes']) && is_array($var['attributes'])) {
                    $variation->options()->attach($var['attributes']);
                }


                if ($request->hasFile("variations.$index.images")) {
                    foreach ($request->file("variations.$index.images") as $imgFile) {
                        $path = $imgFile->store('images/variation_images', 'public');
                        $variation->images()->create(['images' => $path]);
                    }
                }
            }
        });

        return redirect()->back()->with('success', 'Product created successfully.');
    }




    public function CreateProductPage()
    {
        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();

        $allAttributes = Attribute::select('id', 'name')->get();

        return Inertia::render('CreateProduct', [
            'categories' => $categories,
            'brands' => $brands,
            'allAttributes' => $allAttributes,
        ]);
    }
}
