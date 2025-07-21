<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\VariationOption;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $remarks = ['Popular', 'New', 'Top', 'Special', 'Trending', 'Regular'];

        for ($i = 0; $i < 30; $i++) {
            $title = fake()->unique()->words(rand(2, 4), true);
            $price = fake()->numberBetween(500, 5000);
            $stock = fake()->numberBetween(500, 5000);
            $discount = fake()->boolean(70) ? fake()->numberBetween(10, 40) : 0;
            $discount_price = $discount ? round($price - ($price * $discount / 100)) : $price;

            Product::create([
                'title'          => ucfirst($title),
                'short_des'      => fake()->sentence(12),
                'long_des'       => fake()->paragraph(5),
                'price'          => $price,
                'discount'       => $discount,
                'discount_price' => $discount_price,
                'image'          => 'https://placehold.co/300x300.png?text=' . urlencode($title),
                'stock'          => $stock,
                'remark'         => $remarks[array_rand($remarks)],
                'category_id'    => Category::inRandomOrder()->first()->id,
                'brand_id'       => Brand::inRandomOrder()->first()->id,
            ]);
        }
    }
}
