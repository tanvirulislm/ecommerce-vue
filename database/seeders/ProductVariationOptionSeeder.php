<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Database\Seeder;
use App\Models\ProductVariationOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductVariationOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $variations = Variation::with('variationOptions')->get();

        foreach ($products as $product) {
            foreach ($variations as $variation) {
                $options = $variation->variationOptions->random(rand(1, 3));

                foreach ($options as $option) {
                    ProductVariationOption::create([
                        'product_id' => $product->id,
                        'variation_option_id' => $option->id,
                        'image' => fake()->imageUrl(400, 400, 'fashion', true, 'Colorful'),
                        'price_option' => fake()->randomElement([null, '+50', '+100', '-20', '0']),
                    ]);
                }
            }
        }
    }
}
