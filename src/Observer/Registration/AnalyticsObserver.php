<?php

declare(strict_types=1);

namespace Patterns\Observer\Registration;

use Override;

final readonly class AnalyticsObserver implements UserRegisteredObserver
{
    #[Override]
    public function handle(UserRegistered $event): void
    {
        print("Analytics data has been saved for " . $event->name . "\n");
    }
}
