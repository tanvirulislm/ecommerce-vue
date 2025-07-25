<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = \Faker\Factory::create('en_BD');

        foreach (range(1, 20) as $i) {
            Supplier::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => '01' . rand(3, 9,) . rand(10000000, 99999999),
                'city' => $faker->city,
                'address' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
