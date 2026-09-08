<?php

declare(strict_types=1);

namespace Patterns\COR\Registration;

use Override;

final class UniqueEmailHandler extends AbstractRegistrationHandler
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    #[Override]
    public function handle(array $data): ValidationResult
    {
        $email = $data['email'] ?? null;

        if (!is_string($email)) {
            return ValidationResult::failure(
                'The email address is required.',
            );
        }

        if ($this->userRepository->existsByEmail($email)) {
            return ValidationResult::failure(
                'A user with this email address already exists.',
            );
        }

        return parent::handle($data);
    }
}
