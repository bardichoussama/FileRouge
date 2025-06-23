<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\AuthRepositoryInterface;
use App\Models\User;

class AuthRepository implements AuthRepositoryInterface
{
    public function findUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
