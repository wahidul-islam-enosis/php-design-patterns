<?php

declare(strict_types=1);

namespace Patterns\Observer\Registration;

interface UserRegisteredObserver
{
    public function handle(UserRegistered $event): void;
}
