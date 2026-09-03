<?php

declare(strict_types=1);

namespace Patterns\Decorator\Subscription;

use Override;

final class AdditionalUserDecorator implements Subscription
{
    private Subscription $subscription;
    private int $additionalUser;

    public function __construct(Subscription $subscription, int $additionalUser)
    {
        $this->subscription = $subscription;
        $this->additionalUser = $additionalUser;
    }

    #[Override]
    public function priceInCents(): int
    {
        return $this->subscription->priceInCents() + ($this->additionalUser * 300);
    }

    #[Override]
    public function description(): string
    {
        return $this->subscription->description() . "AdditionalUserDecorator: adds 300 cents per additional user" . PHP_EOL;
    }
}
