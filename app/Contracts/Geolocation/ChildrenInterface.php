<?php

namespace App\Contracts\Geolocation;

use Closure;

interface ChildrenInterface
{
    public function handle(array $children, Closure $next);
}
