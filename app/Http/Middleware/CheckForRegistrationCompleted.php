<?php

namespace App\Http\Middleware;

use App\Services\User\UserRolesService;
use Closure;
use Illuminate\Support\Str;

class CheckForRegistrationCompleted
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
        if (auth()->viaRemember()) {
            app(UserRolesService::class)->setDefaultHelperAcarya(auth()->user()->id);
        }

        if (!auth()->user()->isRegistrationCompleted()) {
            if (!Str::endsWith(url()->current(), '/profile') && !(request()->root() === env('AM_URL'))) {
                return redirect('/profile');
            }
        }

        if (
            auth()->check() &&
            !auth()->user()->lessons->count()
            && request()->root() === env('AM_URL') &&
            auth()->user()->isRegistrationCompleted()
        ) {
            if (
                !Str::endsWith(url()->current(), '/user/missing-lessons') &&
                !Str::endsWith(url()->current(), '/user-meditation-lesson') &&
                !Str::endsWith(url()->current(), '/missing-request')
            ) {
                return redirect('/user/missing-lessons');
            }
        }

        return $next($request);
    }
}
