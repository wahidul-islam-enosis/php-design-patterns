<?php

declare(strict_types=1);

namespace Patterns\Decorator\Subscription;

use Override;

final class DiscountDecorator implements Subscription
{
    private Subscription $subscription;
    private readonly int $discountPercent;

    public function __construct(Subscription $subscription, int $discountPercent)
    {
        $this->subscription = $subscription;
        $this->discountPercent = $discountPercent;
    }

    #[Override]
    public function priceInCents(): int
    {
        $subTotal = $this->subscription->priceInCents();
        $discount = intdiv($subTotal * $this->discountPercent, 100);
        return $subTotal - $discount;
    }

    #[Override]
    public function description(): string
    {
        return $this->subscription->description() . "DiscountDecorator: discounts " . $this->discountPercent . "% after all wrapped charges" . PHP_EOL;
    }
}
