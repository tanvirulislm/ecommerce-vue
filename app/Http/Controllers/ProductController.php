<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
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
}
