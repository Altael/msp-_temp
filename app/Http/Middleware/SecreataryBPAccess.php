<?php

namespace App\Http\Middleware;

use Closure;

class SecreataryBPAccess
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

        if (!($user->hasRole('admin') || ($user->hasRole('bp') && $user->bpDistricts()->count()) || ($user->hasRole('secretary') && $user->unit->pivot->title_id))) {
            return redirect('/');
        }

        return $next($request);
    }
}
