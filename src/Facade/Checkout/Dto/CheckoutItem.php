<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout\Dto;

final readonly class CheckoutItem
{
    public function __construct(
        public int $productId,
        public int $quantity
    ) {}
}
