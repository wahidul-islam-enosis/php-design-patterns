<?php

declare(strict_types=1);

namespace Patterns\COR\Registration;

use Override;

final class RequiredFieldHandler extends AbstractRegistrationHandler
{
    private const array REQUIRED_FIELDS = [
        'name',
        'email',
        'password'
    ];

    #[Override]
    public function handle(array $data): ValidationResult
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!$this->hasValue($data, $field)) {
                return ValidationResult::failure(
                    "The {$field} field is required"
                );
            }
        }

        return parent::handle($data);
    }

    private function hasValue(array $data, string $key): bool
    {
        return array_key_exists($key, $data)
            && is_string($data[$key])
            && trim($data[$key]) !== '';
    }
}
