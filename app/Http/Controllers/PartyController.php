<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function CustomerPage()
    {
        $parties = Party::where('type', 'customer')->get();
        return Inertia::render('Customer', [
            'parties' => $parties,
        ]);
    }
    public function SupplierPage()
    {
        $parties = Party::where('type', 'supplier')->get();
        return Inertia::render('Supplier', [
            'parties' => $parties,
        ]);
    }
}
