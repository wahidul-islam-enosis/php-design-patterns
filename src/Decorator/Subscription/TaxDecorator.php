<?php

declare(strict_types=1);

namespace Patterns\Decorator\Subscription;

use Override;

final class TaxDecorator implements Subscription
{
    private Subscription $subscription;
    private readonly int $taxPercent;

    public function __construct(Subscription $subscription, int $taxPercent = 15)
    {
        $this->subscription = $subscription;
        $this->taxPercent = $taxPercent;
    }

    #[Override]
    public function priceInCents(): int
    {
        $subTotal = $this->subscription->priceInCents();
        $tax = intdiv($subTotal * $this->taxPercent, 100);
        return $subTotal + $tax;
    }

    #[Override]
    public function description(): string
    {
        return $this->subscription->description() . "TaxDecorator: adds 15% tax after all wrapped charges" . PHP_EOL;
    }
}
