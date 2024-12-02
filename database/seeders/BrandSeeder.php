<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            [
                'name' => 'NVIDIA',
                'slug' => 'nvidia',
            ],
            [
                'name' => 'ASUS',
                'slug' => 'asus',
            ],
            [
                'name' => 'MSI',
                'slug' => 'msi',
            ],
            [
                'name' => 'ASRock',
                'slug' => 'asrock',
            ],
            [
                'name' => 'Corsair',
                'slug' => 'corsair',
            ],
            [
                'name' => 'G.SKILL',
                'slug' => 'g-skill',
            ],
            [
                'name' => 'Western Digital',
                'slug' => 'western-digital',
            ],
            [
                'name' => 'Seagate',
                'slug' => 'seagate',
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
            ],
            [
                'name' => 'Crucial',
                'slug' => 'crucial',
            ],
            [
                'name' => 'EVGA',
                'slug' => 'evga',
            ],
            [
                'name' => 'be quiet!',
                'slug' => 'be-quiet',
            ],
            [
                'name' => 'Cooler Master',
                'slug' => 'cooler-master',
            ],
            [
                'name' => 'Thermaltake',
                'slug' => 'thermaltake',
            ],
            [
                'name' => 'Lian Li',
                'slug' => 'lian-li',
            ],
            [
                'name' => 'Logitech',
                'slug' => 'logitech',
            ],
            [
                'name' => 'Razer',
                'slug' => 'razer',
            ]
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'name' => $brand['name'],
                'slug' => $brand['slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
