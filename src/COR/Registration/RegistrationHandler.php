<?php

declare(strict_types=1);

namespace Patterns\COR\Registration;

interface RegistrationHandler
{
    public function setNext(RegistrationHandler $handler): RegistrationHandler;

    public function handle(array $data): ValidationResult;
}
