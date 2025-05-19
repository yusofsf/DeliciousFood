<?php

namespace Database\Seeders;

use App\Models\Drink;
use Illuminate\Database\Seeder;

class DrinkSeeder extends Seeder
{
    public function run(): void
    {
        $drinks = [
            [
                'name' => 'دلستر خانواده',
                'price' => 40000,
                'img_url' => 'images/drinks/delester.png'
            ],
            [
                'name' => 'نوشابه بطری',
                'price' => 18000,
                'img_url' => 'images/drinks/coke.jpg'
            ],
            [
                'name' => 'نوشابه خانواده',
                'price' => 360000,
                'img_url' => 'images/drinks/coke-lgsize.webp'
            ],
            [
                'name' => 'آب معدنی کوچک',
                'price' => 7000,
                'img_url' => 'images/drinks/water.jpg'
            ],

        ];

        foreach ($drinks as $drink) {
            Drink::create($drink);
        }
    }
} 