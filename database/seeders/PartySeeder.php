<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Party;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = \Faker\Factory::create('en_BD');
        $userIds = User::pluck('id')->toArray();

        foreach (range(1, 20) as $i) {
            Party::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => '01' . rand(3, 9,) . rand(10000000, 99999999),
                'city' => $faker->city,
                'address' => $faker->address,
                'type' => $faker->randomElement(['customer', 'supplier']),
                'created_by' => $faker->randomElement($userIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
