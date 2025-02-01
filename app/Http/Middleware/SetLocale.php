<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Set default locale if none is set
        if (!session()->has('locale')) {
            session()->put('locale', 'en');
        }

        $locale = session()->get('locale');
        \Log::info('Current locale: ' . $locale);
        app()->setLocale($locale);

        return $next($request);
    }
} 