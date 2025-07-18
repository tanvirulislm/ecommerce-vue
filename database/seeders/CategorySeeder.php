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
        // $faker = Faker::create();
        $parentCategories = [];
        for ($i = 0; $i < 10; $i++) {

            $name = fake()->unique()->words(rand(1, 3), true);
            $parentCategories[] = Category::create([
                'name'        => ucfirst($name),
                'slug'        => Str::slug($name),
                'description' => fake()->boolean(70) ? fake()->sentence(15) : null,
                'parent_id'   => null,
            ]);
        }


        for ($i = 0; $i < 25; $i++) {
            $name = fake()->unique()->words(rand(1, 3), true);


            $parent = $parentCategories[array_rand($parentCategories)];

            Category::create([
                'name'        => ucfirst($name),
                'slug'        => Str::slug($name),
                'description' => fake()->boolean(70) ? fake()->sentence(15) : null,
                'parent_id'   => $parent->id,
            ]);
        }
    }
}
