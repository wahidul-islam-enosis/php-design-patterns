<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout\Dto;

final readonly class CheckoutRequest
{
    /**
     * @param list<CheckoutItem> $items
     */
    public function __construct(
        public int  $customerId,
        public array $items,
        public ?string $couponCode,
        public string $paymentToken
    ) {}
}
