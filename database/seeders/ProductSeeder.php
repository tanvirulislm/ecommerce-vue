<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
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
            $stock = fake()->numberBetween(50, 500);
            $discount = fake()->boolean(60) ? fake()->numberBetween(5, 30) : 0;
            $discountPrice = $discount ? round($price - ($price * $discount / 100)) : $price;

            Product::create([
                'title'           => ucfirst($title),
                'short_des'       => fake()->sentence(10),
                'long_des'        => fake()->paragraph(2),
                'price'           => $price,
                'discount'        => $discount,
                'discount_price'  => $discountPrice,
                'image'           => 'https://placehold.co/300x300.png?text=' . urlencode($title),
                'images'          => json_encode([
                    'https://placehold.co/300x300.png?text=' . urlencode($title) . '+1',
                    'https://placehold.co/300x300.png?text=' . urlencode($title) . '+2',
                ]),
                'stock'           => $stock,
                'remark'          => $remarks[array_rand($remarks)],
                'category_id'     => Category::inRandomOrder()->first()->id,
                'brand_id'        => Brand::inRandomOrder()->first()->id,
            ]);
        }
    }
}
