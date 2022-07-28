<?php

namespace App\Http\Middleware;

use Closure;

class CheckForSadvipra
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->has('sadvipra') && $user = auth()->user()) {
            auth()->user()->update([
                'sadvipra' => true
            ]);
        }

        return $next($request);
    }
}
