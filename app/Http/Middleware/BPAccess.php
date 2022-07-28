<?php

namespace App\Http\Middleware;

use Closure;

class BPAccess
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
        $user = auth()->user();

        if (!($user->hasRole('admin') || ($user->hasRole('bp') && $user->bpDistricts()->count()))) {
            return redirect('/');
        }

        return $next($request);
    }
}
