<?php

namespace Database\Seeders;


use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 25; $i++) {
            $product = Product::create([
                'title' => "Product $i",
                'short_des' => "Short description for product $i",
                'long_des' => "This is a longer description for product $i. Great product!",
                'category_id' => rand(1, 5),
                'brand_id' => rand(1, 5),
                'remark' => 'Regular',
                'cover_image' => "https://placehold.co/600x400?text=Product+$i",
                'weight' => rand(100, 1000),
                'barcode' => 'BARCODE' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'meta_title' => "Meta title for product $i",
                'meta_description' => "Meta description for product $i",
                'status' => 'active',
            ]);

            // Create 2 variations per product
            for ($j = 1; $j <= 2; $j++) {
                $variation = $product->variations()->create([
                    'sku' => "SKU{$i}-{$j}",
                    'price' => rand(1000, 5000),
                    'discount_price' => rand(500, 999),
                    'stock' => rand(10, 100),
                ]);


                $images = [
                    "https://placehold.co/200x200?text=Prod{$i}+Var{$j}+Img1",
                    "https://placehold.co/200x200?text=Prod{$i}+Var{$j}+Img2",
                ];

                foreach ($images as $imgUrl) {
                    $variation->images()->create(['images' => $imgUrl]);
                }
            }
        }
    }
}
