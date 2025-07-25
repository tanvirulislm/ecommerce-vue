<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function CustomerPage()
    {
        $customers = Customer::all();
        return Inertia::render('Customer', [
            'customers' => $customers,
        ]);
    }
}
