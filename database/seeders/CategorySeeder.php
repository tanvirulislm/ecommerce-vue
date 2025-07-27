<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Electronics', 'Books', 'Fashion', 'Home & Kitchen', 'Sports', 'Beauty'];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'image' => 'https://placehold.co/150x150.png',
            ]);
        }
    }
}
