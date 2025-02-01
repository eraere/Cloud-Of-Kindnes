<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Compliment;
use App\Models\Category;

class ComplimentsTableSeeder extends Seeder
{
    public function run()
    {
        // Make sure categories exist
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            // Create default categories if none exist
            $categories = collect([
                Category::create(['name' => 'Motivational', 'description' => 'Uplifting compliments to boost your confidence', 'icon' => 'fa-star']),
                Category::create(['name' => 'Funny', 'description' => 'Light-hearted compliments to make you smile', 'icon' => 'fa-face-smile']),
                Category::create(['name' => 'Romantic', 'description' => 'Sweet compliments for your special someone', 'icon' => 'fa-heart']),
                Category::create(['name' => 'Professional', 'description' => 'Work-appropriate compliments for colleagues', 'icon' => 'fa-briefcase']),
                Category::create(['name' => 'Creative', 'description' => 'Artistic and unique compliments', 'icon' => 'fa-palette']),
            ]);
        }

        // Add some sample compliments for each category
        foreach ($categories as $category) {
            Compliment::create([
                'content' => 'This is a sample compliment for ' . $category->name,
                'author' => 'Cloud of Kindness',
                'category_id' => $category->id
            ]);
        }
    }
} 