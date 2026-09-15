<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout\Interface;

use Patterns\Facade\Checkout\Dto\CheckoutItem;

interface OrderService
{
    /**
     * @param list<CheckoutItem> $items
     */
    public function create(
        int $customerId,
        array $items,
        int $totalInCents,
        string $transactionId
    ): int;
}
