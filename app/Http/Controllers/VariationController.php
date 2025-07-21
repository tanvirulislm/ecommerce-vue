<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Variation;
use Illuminate\Http\Request;
use App\Models\VariationOption;

class VariationController extends Controller
{
    public function VariationPage()
    {
        $variations = Variation::all();
        return Inertia::render('Variation', [
            'variations' => $variations,
        ]);
    }
}
