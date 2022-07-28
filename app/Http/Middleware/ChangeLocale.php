<?php

namespace App\Http\Middleware;

use Closure;

class ChangeLocale
{

    public function handle($request, Closure $next, $guard = null)
    {
        if ($lang = request('lang')) {
            auth()->user()->update([
                'language' => $lang
            ]);
            app()->setLocale($lang);
        }

        elseif ($ml = request('ml')) {
            app()->setLocale($ml);
        }

        elseif (auth()->check() && ($locale = auth()->user()->language)) {
            app()->setLocale($locale);
        }

        elseif(!auth()->check()) {
            app()->setLocale('ru');
        }

        return $next($request);
    }
}
