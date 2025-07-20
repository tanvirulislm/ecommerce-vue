<?php

namespace Database\Seeders;

use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VariationOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            'Color' => ['Red', 'Blue', 'Green', 'Black'],
            'Size' => ['S', 'M', 'L', 'XL'],
            'Weight' => ['1kg', '2kg', '3kg', '5kg'],
        ];

        foreach ($options as $variationName => $optionList) {
            $variation = Variation::where('name', $variationName)->first();

            if ($variation) {
                foreach ($optionList as $option) {
                    VariationOption::create([
                        'variation_id' => $variation->id,
                        'name' => $option,
                    ]);
                }
            }
        }
    }
}
