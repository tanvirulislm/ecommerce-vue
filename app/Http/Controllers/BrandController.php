<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function BrandPage()
    {
        $brand = Brand::All();
        return Inertia::render('Brand', [
            'brand' => $brand,
        ]);
    }
}
