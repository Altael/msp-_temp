<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\User\SocialAuthInterface;
use App\Http\Traits\HistoryTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController
{
    use AuthenticatesUsers, HistoryTrait;

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param string $provider
     * @return RedirectResponse
     */
    public function redirectToProvider(string $provider): RedirectResponse
    {
        $sadvipra = request()->has('sadvipra');

        if (request()->root() === env('AM_URL')) {
            session(['userSocial' => $provider]);
            return Socialite::driver($provider)->with(['state' => 'margii' . ($sadvipra ? ';sadvipra' : '')])->redirect();
        }
        session(['userSocial' => $provider]);
        return Socialite::driver($provider)->with(['state' => ($sadvipra ? 'sadvipra' : '')])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param Request $request
     * @param string $provider
     * @return RedirectResponse
     */
    public function handleProviderCallback(Request $request, string $provider): RedirectResponse
    {
        /*if (request('state') === 'margii') {*/
            $user = Socialite::driver($provider)->stateless()->user();
        /*} else {
            $user = Socialite::driver($provider)->user();
        }*/

        $sadvipra = in_array('sadvipra', explode(';', request('state')));

        $platform = ($sadvipra ? 'sadvipra' : (request()->root() === env('AM_URL') ? 'am' : 'app'));

        app(SocialAuthInterface::class)->auth($user, $provider, $platform);

        session()->put('user-avatar', $user->getAvatar());

        return $this->sendLoginResponse($request);
    }

    protected function authenticated(Request $request, $user)
    {
        $margii = in_array('margii', explode(';', request('state')));

        if ($user && (!$user->registration_completed || $user->lessons())) {
            if ($margii) {
                $role = Role::where('slug', 'margii')->value('id');
                $user->roles()->syncWithoutDetaching([$role]);
                $role = Role::where('slug', 'sadhaka')->value('id');
                $user->roles()->detach([$role]);
            }
        }

        $avatar = session()->get('user-avatar');

        if (optional($user->profile)->image === null || optional($user->profile)->image !== $avatar) {
            if ($user->profile) {
                $user->profile->update([
                    'image' => $avatar
                ]);
            }
        }

        $this->saveHistoryLog('user-authenticated');
    }
}
