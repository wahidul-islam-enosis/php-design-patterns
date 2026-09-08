<?php

declare(strict_types=1);

namespace Patterns\Builder\Order;

use LogicException;

final readonly class Item
{
    public function __construct(
        public int $productId,
        public int $quantity,
        public int $unitPriceInCents
    ) {}

    public function validate()
    {
        if ($this->productId < 1) {
            throw new LogicException("Product ID must be positive.");
        }

        if ($this->quantity < 1) {
            throw new LogicException("Quantity must be at least one.");
        }

        if ($this->unitPriceInCents < 0) {
            throw new LogicException("Unit price cannot be negative.");
        }
    }
}
