<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            ['name' => 'Bruschetta', 'type' => 'appetizer', 'price' => 35000, 'tag' => 'vegetarian, garlic', 'image' => '/images/bruschetta.jpg',],
            ['name' => 'Spring Rolls', 'type' => 'appetizer', 'price' => 45000, 'tag' => 'vegan, crispy', 'image' => '/images/spring_rolls.jpg'],
        ]);

        DB::table('food_items')->insert([
            ['name' => 'Grilled Chicken', 'type' => 'main_course', 'price' => 12.99, 'tag' => 'gluten-free', 'im' => '/images/grilled_chicken.jpg'],
            ['name' => 'Pasta Carbonara', 'type' => 'main_course', 'price' => 14.50, 'tag' => 'contains dairy', 'img' => '/images/pasta_carbonara.jpg'],
        ]);
    }
}
