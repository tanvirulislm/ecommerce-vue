<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Variation;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InvoiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $invoices = Invoice::all();

        foreach ($invoices as $invoice) {
            $total = 0;

            foreach (range(1, rand(1, 4)) as $i) {
                $product = Product::inRandomOrder()->first();
                $variation = Variation::where('product_id', $product->id)->inRandomOrder()->first();

                $quantity = rand(1, 5);
                $unitPrice = $variation?->price ?? $product->price ?? rand(100, 500);
                $subtotal = $unitPrice * $quantity;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'variation_id' => $variation?->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $invoice->update([
                'total_amount' => $total
            ]);
        }
    }
}
