<?php

namespace Database\Seeders;

use App\Enums\FoodType;
use App\Models\Food;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [
            [
                'name' => 'قارچ برگر',
                'ingredients' => 'همبرگر، قارچ، کاهو، گوجه، خیار شور، نان باگت',
                'price' => 150000,
                'type' => FoodType::Burger->value,
                'img_url' => 'images/burgers/mushroomburger.jpg'
            ],
            [
                'name' => 'چیز برگر',
                'ingredients' => 'همبرگر، پنیر پیتزا، کاهو، گوجه، خیار شور، نان باگت',
                'price' => 130000,
                'type' => FoodType::Burger->value,
                'img_url' => 'images/burgers/cheeseburger.jpg'
            ],
            [
                'name' => 'دبل برگر',
                'ingredients' => 'دو عدد همبرگر، کاهو، گوجه، خیار شور، نان باگت',
                'price' => 180000,
                'type' => FoodType::Burger->value,
                'img_url' => 'images/burgers/double.jpg'
            ],
            [
                'name' => 'همبرگر',
                'ingredients' => 'همبرگر، کاهو، گوجه، خیار شور، نان باگت',
                'price' => 100000,
                'type' => FoodType::Burger->value,
                'img_url' => 'images/burgers/hamburger.jpg'
            ],
            [
                'name' => 'همبرگر با کالباس',
                'ingredients' => 'همبرگر، کالباس، کاهو، گوجه، خیار شور، نان باگت',
                'price' => 100000,
                'type' => FoodType::Burger->value,
                'img_url' => 'images/burgers/hamburgerwithham.jpg'
            ],

            [
                'name' => 'ژامبون مرغ',
                'ingredients' => 'کالباس مرغ 80 درصد، کاهو، گوجه، خیار شور، نان باگت',
                'price' => 100000,
                'type' => FoodType::Sandwich->value,
                'img_url' => 'images/sandwiches/ham.jpg'
            ],
            [
                'name' => 'گوشت',
                'ingredients' => 'گوشت گوساله ریش ریش شده، کاهو، گوجه، خیار شور، نان باگت',
                'price' => 220000,
                'type' => FoodType::Sandwich->value,
                'img_url' => 'images/sandwiches/roastbeef.jpeg'
            ],
            [
                'name' => 'هات داگ',
                'ingredients' => 'هات داگ، کاهو، گوجه، خیار شور، نان باگت',
                'price' => 130000,
                'type' => FoodType::Sandwich->value,
                'img_url' => 'images/sandwiches/hotdog.jpg'
            ],
            [
                'name' => 'مرغ',
                'ingredients' => 'سینه مرغ ریش ریش شده، کاهو، گوجه، خیارشور، نان باگت',
                'price' => 100000,
                'type' => FoodType::Sandwich->value,
                'img_url' => 'images/sandwiches/chicken-sandwich.webp'
            ],
            [
                'name' => 'خوراک',
                'ingredients' => 'خوراک هندی، رب، کاهو، گوجه، خیارشور، نان باگت',
                'price' => 110000,
                'type' => FoodType::Sandwich->value,
                'img_url' => 'images/sandwiches/khorak.jpg'
            ],

            [
                'name' => 'سالاد کلم',
                'ingredients' => 'یک نفره، با سس مخصوص',
                'price' => 30000,
                'type' => FoodType::Extra->value,
                'img_url' => 'images/extras/salad.jpg'
            ],
            [
                'name' => 'سیب زمینی ساده',
                'ingredients' => 'خلال سیب زمینی سرخ شده',
                'price' => 60000,
                'type' => FoodType::Extra->value,
                'img_url' => 'images/extras/french-fries.jpg'
            ],
            [
                'name' => 'سس سیر',
                'ingredients' => 'یک نفره، دست ساز',
                'price' => 10000,
                'type' => FoodType::Extra->value,
                'img_url' => 'images/extras/garlic-sauce.jpg'
            ],
            [
                'name' => 'سس مایونز',
                'ingredients' => 'یک نفره، شرکتی',
                'price' => 2000,
                'type' => FoodType::Extra->value,
                'img_url' => 'images/extras/mayonause-sauce.jpg'
            ],
        ];


        foreach ($foods as $food) {
            Food::create($food);
        }
    }
} 