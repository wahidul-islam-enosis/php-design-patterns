<?php

declare(strict_types=1);

namespace Patterns\COR\Registration;

final readonly class ValidationResult
{
    private function __construct(
        public bool $valid,
        public ?string $error
    ) {}

    public static function success(): self
    {
        return new self(
            valid: true,
            error: null
        );
    }

    public static function failure(string $error): self
    {
        return new self(
            valid: false,
            error: $error
        );
    }
}
