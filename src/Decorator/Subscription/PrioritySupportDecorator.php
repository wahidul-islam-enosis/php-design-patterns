<?php

declare(strict_types=1);

namespace Patterns\Decorator\Subscription;

use Override;

final class PrioritySupportDecorator implements Subscription
{
    private Subscription $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    #[Override]
    public function priceInCents(): int
    {
        return $this->subscription->priceInCents() + 1000;
    }

    #[Override]
    public function description(): string
    {
        return $this->subscription->description() . "PrioritySupportDecorator: adds 1,000 cents" . PHP_EOL;
    }
}
