<?php

namespace Database\Seeders;

use App\Models\Compliment;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ComplimentSeeder extends Seeder
{
    public function run(): void
    {
        $motivationalId = Category::where('slug', 'motivational')->first()->id;
        $funnyId = Category::where('slug', 'funny')->first()->id;
        $romanticId = Category::where('slug', 'romantic')->first()->id;

        $compliments = [
            [
                'category_id' => $motivationalId,
                'content' => 'Your determination is truly inspiring!',
                'author' => 'Cloud of Kindness'
            ],
            [
                'category_id' => $motivationalId,
                'content' => 'You have the power to make a difference!',
                'author' => 'Cloud of Kindness'
            ],
            [
                'category_id' => $funnyId,
                'content' => 'You make my dopamine levels go brrr!',
                'author' => 'Cloud of Kindness'
            ],
            [
                'category_id' => $funnyId,
                'content' => "You're funnier than a cat video marathon!",
                'author' => 'Cloud of Kindness'
            ],
            [
                'category_id' => $romanticId,
                'content' => 'You make my heart skip a beat!',
                'author' => 'Cloud of Kindness'
            ],
            [
                'category_id' => $romanticId,
                'content' => 'Your smile lights up my whole world!',
                'author' => 'Cloud of Kindness'
            ],
        ];

        foreach ($compliments as $compliment) {
            Compliment::create($compliment);
        }
    }
} 