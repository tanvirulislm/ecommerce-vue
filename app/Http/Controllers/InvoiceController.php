<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function InvoicePage()
    {
        $invoices = Invoice::with('party')->get();
        return Inertia::render('Invoice', [
            'invoices' => $invoices,
        ]);
    }
}
