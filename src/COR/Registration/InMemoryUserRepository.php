<?php

declare(strict_types=1);

namespace Patterns\COR\Registration;

use Override;

final class InMemoryUserRepository implements UserRepository
{
    private array $emails;

    public function __construct(array $emails = [])
    {
        $this->emails = array_map(
            static fn(string $email): string => strtolower($email),
            $emails
        );
    }

    #[Override]
    public function existsByEmail(string $email): bool
    {
        return in_array(strtolower($email), $this->emails, true);
    }
}
