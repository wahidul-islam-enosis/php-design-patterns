<?php

declare(strict_types=1);

namespace Patterns\COR\Registration;

use Override;

final class EmailFormatHandler extends AbstractRegistrationHandler
{
    #[Override]
    public function handle(array $data): ValidationResult
    {
        $email = $data['email'] ?? null;
        if (!is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return ValidationResult::failure(
                'The email is invalid'
            );
        }

        return parent::handle($data);
    }
}
