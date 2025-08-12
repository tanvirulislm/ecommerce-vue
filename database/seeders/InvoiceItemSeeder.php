<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InvoiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Assuming you have invoices and product_variations already seeded
        $invoiceIds = DB::table('invoices')->pluck('id')->toArray();
        $variationIds = DB::table('product_variations')->pluck('id')->toArray();

        // Generate 50 random invoice items
        for ($i = 0; $i < 50; $i++) {
            $invoiceId = $invoiceIds[array_rand($invoiceIds)];
            $variationId = $variationIds[array_rand($variationIds)];
            $quantity = rand(1, 10);
            $unitPrice = rand(100, 1000);
            $subtotal = $quantity * $unitPrice;

            DB::table('invoice_items')->insert([
                'invoice_id' => $invoiceId,
                'product_variation_id' => $variationId,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
