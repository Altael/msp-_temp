<?php

namespace App\Contracts\User;

use Laravel\Socialite\Contracts\User;

interface SocialAuthInterface
{
    public function auth(User $user, string $provider, string $platform);
}
