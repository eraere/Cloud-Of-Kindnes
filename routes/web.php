<?php

use App\Http\Controllers\ComplimentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ComplimentController::class, 'index'])->name('home');
Route::get('/compliments/random', [ComplimentController::class, 'random'])->name('compliments.random');
Route::get('/compliments/{compliment}', [ComplimentController::class, 'show'])->name('compliments.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/compliments/{compliment}/favorite', [ComplimentController::class, 'toggleFavorite'])->name('compliments.favorite');
    Route::post('/compliments/{compliment}/share', [ComplimentController::class, 'share'])->name('compliments.share');
});

Route::post('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'sq'])) {
        session()->put('locale', $locale);
        app()->setLocale($locale);
        
        // Force the locale to persist
        session()->save();
        
        \Log::info('Language switched', [
            'new_locale' => $locale,
            'session_locale' => session()->get('locale'),
            'app_locale' => app()->getLocale(),
            'session_id' => session()->getId()
        ]);
    }
    return redirect()->back();
})->name('language')->middleware('web');

Route::post('/voice-command', [ComplimentController::class, 'processVoiceCommand'])->name('voice.command');
