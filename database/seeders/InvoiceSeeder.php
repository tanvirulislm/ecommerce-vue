<?php

namespace Database\Seeders;

use App\Models\Party;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (range(1, 30) as $i) {
            $type = fake()->randomElement(['purchase', 'sale']);

            $party = Party::where('type', $type === 'purchase' ? 'supplier' : 'customer')
                ->inRandomOrder()
                ->first();

            Invoice::create([
                'invoice_number' => 'INV-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'type' => $type,
                'party_id' => $party?->id,
                'total_amount' => $total = rand(2000, 10000),
                'paid_amount' => $paid = rand(1000, $total),
                'payment_status' => $paid >= $total ? 'paid' : ($paid == 0 ? 'unpaid' : 'partial'),
                'invoice_date' => now()->subDays(rand(0, 30)),
                'due_date' => now()->addDays(rand(5, 15)),
                'note' => fake()->sentence(),
            ]);
        }
    }
}
