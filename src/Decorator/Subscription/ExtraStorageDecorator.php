<?php

declare(strict_types=1);

namespace Patterns\Decorator\Subscription;

use Override;

final class ExtraStorageDecorator implements Subscription
{
    private Subscription $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    #[Override]
    public function priceInCents(): int
    {
        return $this->subscription->priceInCents() + 500;
    }

    #[Override]
    public function description(): string
    {
        return $this->subscription->description() . "ExtraStorageDecorator: adds 500 cents" . PHP_EOL;
    }
}
