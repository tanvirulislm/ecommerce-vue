<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function SalesInvoicePage()
    {
        $invoices = Invoice::whereHas('party', function ($query) {
            $query->where('type', 'customer');
        })->with('party')->get();
        return Inertia::render('SalesInvoice', [
            'invoices' => $invoices,
        ]);
    }
    public function PurchaseInvoicePage()
    {
        $invoices = Invoice::whereHas('party', function ($query) {
            $query->where('type', 'supplier');
        })->with('party')->get();
        return Inertia::render('PurchaseInvoice', [
            'invoices' => $invoices,
        ]);
    }
}
