<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout\Interface;

use Patterns\Facade\Checkout\Dto\CheckoutItem;

interface PricingService
{
    /**
     * @param list<CheckoutItem> $items
     */
    public function calculateTotal(
        array $items,
        ?string $couponCode
    ): int;
}
