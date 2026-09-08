<?php

declare(strict_types=1);

namespace Patterns\COR\Registration;

interface UserRepository
{
    public function existsByEmail(string $email): bool;
}
