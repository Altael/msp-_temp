<?php

namespace App\Contracts\User;

interface AcaryaHelperRepositoryInterface
{
    public function getAcaryasByHelperId(int $helperId): array;
}
