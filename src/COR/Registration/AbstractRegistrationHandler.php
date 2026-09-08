<?php

declare(strict_types=1);

namespace Patterns\COR\Registration;

use Override;

abstract class AbstractRegistrationHandler implements RegistrationHandler
{
    private ?RegistrationHandler $nextHandler = null;

    #[Override]
    public function setNext(RegistrationHandler $handler): RegistrationHandler
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    #[Override]
    public function handle(array $data): ValidationResult
    {
        if ($this->nextHandler !== null) {
            return $this->nextHandler->handle($data);
        }

        return ValidationResult::success();
    }
}
