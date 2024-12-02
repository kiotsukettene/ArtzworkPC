<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Network Interface Card',
                'slug' => 'network-interface-card',
                'sku' => 'NTC',
                'specifications' => [
                    'Interface Type',
                    'Network Speed',
                    'Port Type',
                    'Wi-Fi Standards',
                    'Bluetooth Version'
                ]
            ],
            [
                'name' => 'Sound Card',
                'slug' => 'sound-card',
                'sku' => 'SND',
                'specifications' => [
                    'Audio Channels',
                    'Sample Rate',
                    'SNR',
                    'Interface Type',
                    'Digital Audio Format'
                ]
            ],
            [
                'name' => 'Keyboard',
                'slug' => 'keyboard',
                'sku' => 'KBD',
                'specifications' => [
                    'Switch Type',
                    'Layout',
                    'Connectivity',
                    'Backlight',
                    'Key Rollover'
                ]
            ],
            [
                'name' => 'Mouse',
                'slug' => 'mouse',
                'sku' => 'MSE',
                'specifications' => [
                    'DPI Range',
                    'Sensor Type',
                    'Button Count',
                    'Connectivity',
                    'Weight'
                ]
            ],
            [
                'name' => 'Webcam',
                'slug' => 'webcam',
                'sku' => 'WBC',
                'specifications' => [
                    'Resolution',
                    'Frame Rate',
                    'Focus Type',
                    'Microphone',
                    'Connection Type'
                ]
            ],
            [
                'name' => 'External Hard Drive',
                'slug' => 'external-hard-drive',
                'sku' => 'XHD',
                'specifications' => [
                    'Storage Capacity',
                    'Interface',
                    'Drive Speed',
                    'Form Factor',
                    'Power Source'
                ]
            ],
            [
                'name' => 'Gaming Headset',
                'slug' => 'gaming-headset',
                'sku' => 'GHS',
                'specifications' => [
                    'Driver Size',
                    'Frequency Response',
                    'Microphone Type',
                    'Connection Type',
                    'Surround Sound'
                ]
            ],
            [
                'name' => 'USB Hub',
                'slug' => 'usb-hub',
                'sku' => 'USB',
                'specifications' => [
                    'Port Count',
                    'USB Version',
                    'Power Delivery',
                    'Data Transfer Speed',
                    'Power Source'
                ]
            ]
        ];

        foreach ($categories as $category) {
            // Insert category
            $categoryId = DB::table('categories')->insertGetId([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'sku' => $category['sku'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert specifications for this category
            foreach ($category['specifications'] as $specName) {
                DB::table('specifications')->insert([
                    'category_id' => $categoryId,
                    'name' => $specName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
