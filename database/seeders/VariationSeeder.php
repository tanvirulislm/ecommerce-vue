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
            'Size'   => ['Small', 'Medium', 'Large'],
            'Color'  => ['Red', 'Green', 'Blue', 'Black'],
            'Weight' => ['250g', '500g', '1kg'],
            'Type'   => ['Basic', 'Premium', 'Limited'],
        ];

        $products = Product::all();

        foreach ($products as $product) {
            $pickedNames = collect($variationNames)->random(rand(1, 2));

            foreach ($pickedNames as $name) {
                $options = $optionsMap[$name];

                foreach ($options as $option) {
                    Variation::create([
                        'name'       => $name,
                        'option'     => $option,
                        'image'      => 'https://placehold.co/100x100?text=' . $option,
                        'price'      => rand(50, 300),
                        'stock'      => rand(10, 50),
                        'product_id' => $product->id,
                    ]);
                }
            }
        }
    }
}
