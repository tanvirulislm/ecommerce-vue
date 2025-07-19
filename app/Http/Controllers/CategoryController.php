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
        // return $category;
    }
}
