<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function Categorypage(Request $request)
    {
        return Inertia::render('Category');
    }
}
