<?php

declare(strict_types=1);

namespace Patterns\Builder\Order;

final readonly class Order
{
    public function __construct(
        public string $customerEmail,
        /** @var array<int, Item> */
        public array $items,
        public ?string $shippingAddress,
        public ?string $couponCode,
        public bool $giftWrapping,
    ) {}

    public function subtotalInCents(): int
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += ($item->unitPriceInCents * $item->quantity);
        }

        return $total;
    }
}
