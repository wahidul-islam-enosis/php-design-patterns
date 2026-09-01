<?php

declare(strict_types=1);

namespace Patterns\Observer\Registration;

use Override;

final readonly class WelcomeEmailObserver implements UserRegisteredObserver
{
    #[Override]
    public function handle(UserRegistered $event): void
    {
        print("User email has been sent to " . $event->email . "\n");
    }
}
