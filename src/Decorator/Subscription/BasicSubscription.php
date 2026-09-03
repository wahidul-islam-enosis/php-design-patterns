<?php

declare(strict_types=1);

namespace Patterns\Decorator\Subscription;

use Override;

final class BasicSubscription implements Subscription
{
    #[Override]
    public function priceInCents(): int
    {
        return 2000;
    }

    #[Override]
    public function description(): string
    {
        return "Basic subscription: 2,000 cents" . PHP_EOL;
    }
}
