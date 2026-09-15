<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout\Interface;

interface InventoryService
{
    public function reserve(
        int $productId,
        int $quantity
    ): void;
}
