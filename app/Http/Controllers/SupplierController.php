<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function SupplierPage()
    {
        $suppliers = Supplier::all();
        return Inertia::render('Supplier', [
            'suppliers' => $suppliers,
        ]);
    }
}
