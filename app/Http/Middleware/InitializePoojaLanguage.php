<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;         // ← add this
use Illuminate\Support\Facades\Session;     // ← optional, but makes Session usage explicit

class InitializePoojaLanguage
{
    public function handle(Request $request, Closure $next)
    {
        // At this point, the session IS available (once the ordering is correct)
        if (! Session::has('pooja_language')) {
            Session::put('pooja_language', 'English');
        }

        // Now we can set the application locale
        $locale = Session::get('pooja_language') === 'English' ? 'en' : 'hi';
        App::setLocale($locale);

        return $next($request);
    }
}
