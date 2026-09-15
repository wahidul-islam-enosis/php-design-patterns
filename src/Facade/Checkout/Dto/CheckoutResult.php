<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout\Dto;

final readonly class CheckoutResult
{
    public function __construct(
        public int $orderId,
        public string $transactionId,
        public int $chargedAmount
    ) {}
}
