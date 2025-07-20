<?php

namespace Database\Seeders;

use App\Models\Variation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variations = [
            'Color',
            'Size',
            'Weight',
        ];

        foreach ($variations as $name) {
            Variation::create(['name' => $name]);
        }
    }
}
