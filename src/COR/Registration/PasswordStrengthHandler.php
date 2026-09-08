<?php

declare(strict_types=1);

namespace Patterns\COR\Registration;

use Override;

final class PasswordStrengthHandler extends AbstractRegistrationHandler
{
    #[Override]
    public function handle(array $data): ValidationResult
    {
        $password = $data['password'] ?? null;
        if (!is_string($password) || strlen($password) < 8) {
            return ValidationResult::failure(
                'The password must contain at least 8 characters.'
            );
        }

        if (preg_match('/[A-Z]/', $password) !== 1) {
            return ValidationResult::failure(
                'The password must contain an uppercase letter.',
            );
        }

        if (preg_match('/[a-z]/', $password) !== 1) {
            return ValidationResult::failure(
                'The password must contain a lowercase letter.',
            );
        }

        if (preg_match('/[0-9]/', $password) !== 1) {
            return ValidationResult::failure(
                'The password must contain a number.',
            );
        }

        return parent::handle($data);
    }
}
