<?php

declare(strict_types=1);

namespace Patterns\COR\Registration;

use Override;

final class RegistrationSuccessHandler extends AbstractRegistrationHandler
{
    #[Override]
    public function handle(array $data): ValidationResult
    {
        return ValidationResult::success();
    }
}
