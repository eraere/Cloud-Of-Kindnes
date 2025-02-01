<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Compliment;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create categories
        $categories = [
            [
                'name' => 'Motivational',
                'slug' => 'motivational',
                'icon' => 'fa-star',
                'description' => 'Uplifting compliments to boost your confidence'
            ],
            [
                'name' => 'Funny',
                'slug' => 'funny',
                'icon' => 'fa-face-smile',
                'description' => 'Light-hearted compliments to make you smile'
            ],
            [
                'name' => 'Romantic',
                'slug' => 'romantic',
                'icon' => 'fa-heart',
                'description' => 'Sweet compliments for your special someone'
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'icon' => 'fa-briefcase',
                'description' => 'Work-appropriate compliments for colleagues'
            ],
            [
                'name' => 'Creative',
                'slug' => 'creative',
                'icon' => 'fa-palette',
                'description' => 'Artistic and unique compliments'
            ]
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create sample compliments for each category
        $allCompliments = [
            1 => [
                'en' => [
                    'You make everything look effortless!',
                    'Your potential is limitless!',
                    'You inspire everyone around you!',
                    'Your dedication is truly admirable!'
                ],
                'sq' => [
                    'Je një sukses që po ndodh çdo ditë!',
                    'Asgjë s\'të ndal, sepse ti je vetë forca!',
                    'Je një hap larg madhështisë, vazhdo përpara!',
                    'Frymëzon edhe diellin të shkëlqejë më shumë!'
                ]
            ],
            2 => [
                'en' => [
                    'You make my dopamine levels go brrr!',
                    'You\'re cooler than a penguin in sunglasses!',
                    'You\'re more fun than bubble wrap!',
                    'You\'re the human equivalent of a pizza!'
                ],
                'sq' => [
                    'Ti je si WiFi i fortë – të duan të gjithë!',
                    'Shkëlqen aq shumë sa s\'duhet të të lëmë pranë paneleve diellore!',
                    'Bukuria jote ka nevojë për leje ndërtimi – është shumë e lartë!',
                    'Ke kaq shumë talent sa duhet të paguajmë për t\'u afruar me ty!'
                ]
            ],
            3 => [
                'en' => [
                    'You make my heart skip a beat!',
                    'Your smile lights up my world!',
                    'You\'re the missing piece to my puzzle!',
                    'Every moment with you is magical!'
                ],
                'sq' => [
                    'Ti je ëndrra që s\'dua të zgjohem kurrë!',
                    'Buzëqeshja jote është magji e pastër!',
                    'Syte e tu janë si yje, por më të bukur!',
                    'Nëse do ishe melodi, do ishe hiti im i përjetshëm!'
                ]
            ],
            4 => [
                'en' => [
                    'Your work ethic is outstanding!',
                    'Your attention to detail is remarkable!',
                    'You bring such value to the team!',
                    'Your leadership skills are inspiring!'
                ],
                'sq' => [
                    'Me ty puna bëhet art!',
                    'Ti nuk punon thjesht – ti krijon!',
                    'Idetë e tua e bëjnë botën më të zgjuar!',
                    'Ti je versioni profesional i suksesit!'
                ]
            ],
            5 => [
                'en' => [
                    'Your creativity knows no bounds!',
                    'Your imagination is truly magical!',
                    'You see beauty in everything!',
                    'Your artistic vision is unique!'
                ],
                'sq' => [
                    'Fantazia jote s\'ka kufij!',
                    'Ti sheh botën me sy artisti!',
                    'Idetë e tua janë si yje – ndriçojnë gjithçka!',
                    'Krijimtaria jote është frymëzim i pastër!'
                ]
            ]
        ];

        foreach ($allCompliments as $categoryId => $translations) {
            foreach ($translations['en'] as $index => $content) {
                Compliment::create([
                    'category_id' => $categoryId,
                    'content' => $content,
                    'content_sq' => $translations['sq'][$index],
                    'author' => app()->getLocale() === 'sq' ? 'Retë e Mirësisë' : 'Cloud of Kindness'
                ]);
            }
        }
    }
}
