<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!auth()->user()->hasOneRole(['admin', 'acarya', 'secretary', 'helper', 'bp'])) {
            return redirect('/user');
        }

        return $next($request);
    }
}
