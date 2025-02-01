<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Motivational',
                'icon' => 'fa-star',
                'description' => 'Uplifting compliments to boost your confidence'
            ],
            [
                'name' => 'Funny',
                'icon' => 'fa-laugh',
                'description' => 'Light-hearted compliments to make you smile'
            ],
            [
                'name' => 'Romantic',
                'icon' => 'fa-heart',
                'description' => 'Sweet compliments for your special someone'
            ],
            [
                'name' => 'Professional',
                'icon' => 'fa-briefcase',
                'description' => 'Work-appropriate compliments for colleagues'
            ],
            [
                'name' => 'Creative',
                'icon' => 'fa-palette',
                'description' => 'Artistic and unique compliments'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'description' => $category['description']
            ]);
        }
    }
} 