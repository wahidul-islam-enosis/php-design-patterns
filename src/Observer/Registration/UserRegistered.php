<?php

declare(strict_types=1);

namespace Patterns\Observer\Registration;

final readonly class UserRegistered
{
    public function __construct(
        public int $userId,
        public string $name,
        public string $email
    ) {}
}
