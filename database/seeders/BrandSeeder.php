<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Apple', 'img' => 'https://logo.clearbit.com/apple.com'],
            ['name' => 'Samsung', 'img' => 'https://logo.clearbit.com/samsung.com'],
            ['name' => 'Sony', 'img' => 'https://logo.clearbit.com/sony.com'],
            ['name' => 'Nike', 'img' => 'https://logo.clearbit.com/nike.com'],
            ['name' => 'Adidas', 'img' => 'https://logo.clearbit.com/adidas.com'],
            ['name' => 'Google', 'img' => 'https://logo.clearbit.com/google.com'],
            ['name' => 'Amazon', 'img' => 'https://logo.clearbit.com/amazon.com'],
            ['name' => 'Microsoft', 'img' => 'https://logo.clearbit.com/microsoft.com'],
            ['name' => 'Xiaomi', 'img' => 'https://logo.clearbit.com/mi.com'],
            ['name' => 'OnePlus', 'img' => 'https://logo.clearbit.com/oneplus.com'],
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'brandName' => $brand['name'],
                'brandImg'  => $brand['img'],
            ]);
        }
    }
}
