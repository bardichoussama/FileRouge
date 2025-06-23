<?php

namespace Modules\PkgSessionDeSuivi\Domain\Interfaces;

interface AuthRepositoryInterface
{
    public function findUserByEmail(string $email);
}
