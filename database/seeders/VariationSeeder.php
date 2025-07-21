<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variationNames = ['Size', 'Color', 'Weight', 'Type'];
        $optionsMap = [
            'Size' => ['Small', 'Medium', 'Large'],
            'Color' => ['Red', 'Green', 'Blue', 'Black'],
            'Weight' => ['250g', '500g', '1kg'],
            'Type' => ['Basic', 'Premium', 'Limited'],
        ];

        $products = Product::all();

        foreach ($products as $product) {
            $count = rand(1, 2);
            $pickedNames = collect($variationNames)->random($count);

            foreach ($pickedNames as $name) {
                Variation::create([
                    'name'       => $name,
                    'options'    => json_encode(collect($optionsMap[$name])->random(rand(1, 3))),
                    'image'      => 'https://placehold.co/100x100?text=' . $name,
                    'price'      => rand(50, 300),
                    'stock'      => rand(10, 50),
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
