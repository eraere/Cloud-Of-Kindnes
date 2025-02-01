<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Compliment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ComplimentController extends Controller
{
    public function index()
    {
        // Force locale at the start of the request
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }

        $categories = Category::all();
        $randomCompliment = Compliment::inRandomOrder()->first();
        $popularCompliments = Cache::remember('popular_compliments', 3600, function () {
            return Compliment::orderBy('likes_count', 'desc')
                ->take(5)
                ->get();
        });

        // Debug information
        \Log::info('Index page loaded', [
            'session_locale' => session()->get('locale'),
            'app_locale' => app()->getLocale(),
            'session_id' => session()->getId()
        ]);

        return view('compliments.index', compact('categories', 'randomCompliment', 'popularCompliments'));
    }

    public function random(Request $request)
    {
        try {
            // Force locale at the start of the request
            if (session()->has('locale')) {
                app()->setLocale(session()->get('locale'));
            }

            $query = Compliment::query();
            
            if ($request->filled('category')) {
                $categoryId = $request->input('category');
                $query->where('category_id', $categoryId);
            }

            $compliment = $query->inRandomOrder()->first();

            if (!$compliment) {
                return response()->json([
                    'content' => app()->getLocale() === 'sq' ? 
                        'Nuk u gjetën komplimente në këtë kategori!' : 
                        'No compliments found in this category yet!',
                    'author' => app()->getLocale() === 'sq' ? 'Retë e Mirësisë' : 'Cloud of Kindness'
                ], 404);
            }

            // Get content based on current locale
            $content = app()->getLocale() === 'sq' ? $compliment->content_sq : $compliment->content;
            $author = app()->getLocale() === 'sq' ? 'Retë e Mirësisë' : 'Cloud of Kindness';

            // Debug logging
            \Log::info('Random compliment request', [
                'locale' => app()->getLocale(),
                'session_locale' => session()->get('locale'),
                'content_type' => app()->getLocale() === 'sq' ? 'Albanian' : 'English',
                'content' => $content
            ]);

            return response()->json([
                'content' => $content,
                'id' => $compliment->id,
                'author' => $compliment->author ?? $author
            ]);
        } catch (\Exception $e) {
            \Log::error('Compliment generation error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'content' => app()->getLocale() === 'sq' ? 
                    'Diçka shkoi keq. Ju lutemi provoni përsëri.' : 
                    'Something went wrong. Please try again.',
                'author' => 'System'
            ], 500);
        }
    }

    public function toggleFavorite(Compliment $compliment)
    {
        $user = auth()->user();
        $user->favoriteCompliments()->toggle($compliment);

        return response()->json([
            'isFavorited' => $user->favoriteCompliments()->where('compliment_id', $compliment->id)->exists(),
        ]);
    }

    public function share(Compliment $compliment)
    {
        try {
            $compliment->increment('shares_count');
            
            // Get the content based on current locale
            $content = app()->getLocale() === 'sq' ? $compliment->content_sq : $compliment->content;
            
            return response()->json([
                'success' => true,
                'content' => $content,
                'share_url' => url('/') // Just share the main site URL
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sharing compliment'
            ], 500);
        }
    }

    public function show(Compliment $compliment)
    {
        return view('compliments.show', [
            'compliment' => $compliment,
            'content' => app()->getLocale() === 'sq' ? $compliment->content_sq : $compliment->content,
            'author' => app()->getLocale() === 'sq' ? 'Retë e Mirësisë' : 'Cloud of Kindness'
        ]);
    }

    public function processVoiceCommand(Request $request)
    {
        try {
            $command = strtolower($request->input('command'));
            $locale = app()->getLocale();
            
            // Define commands for both languages
            $generateCommands = [
                'en' => ['generate', 'new', 'next', 'another'],
                'sq' => ['gjenero', 'tjetër', 'vazhdoni']
            ];
            
            if (in_array($command, $generateCommands[$locale])) {
                $compliment = Compliment::inRandomOrder()->first();
                
                return response()->json([
                    'success' => true,
                    'action' => 'generate',
                    'content' => $locale === 'sq' ? $compliment->content_sq : $compliment->content,
                    'author' => $locale === 'sq' ? 'Retë e Mirësisë' : 'Cloud of Kindness'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => $locale === 'sq' ? 
                    'Komanda nuk u njoh' : 
                    'Command not recognized'
            ]);
        } catch (\Exception $e) {
            \Log::error('Voice command error', [
                'message' => $e->getMessage(),
                'command' => $request->input('command')
            ]);
            
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() === 'sq' ? 
                    'Diçka shkoi keq' : 
                    'Something went wrong'
            ], 500);
        }
    }
} 