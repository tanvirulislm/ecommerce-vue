<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function PartyPage()
    {
        $parties = Party::all();
        return Inertia::render('Party', [
            'parties' => $parties,
        ]);
    }
}
