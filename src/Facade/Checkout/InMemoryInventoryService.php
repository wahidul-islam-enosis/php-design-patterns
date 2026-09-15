<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout;

use Override;
use Patterns\Facade\Checkout\Exception\InsufficientInventory;
use Patterns\Facade\Checkout\Interface\InventoryService;

final class InMemoryInventoryService implements InventoryService
{
    /**
     * @param array<int, int> $availableStock
     */
    public function __construct(
        private array $availableStock
    ) {}

    #[Override]
    public function reserve(int $productId, int $quantity): void
    {
        $available = $this->availableStock($productId);

        if ($available < $quantity) {
            throw new InsufficientInventory(
                "Product {$productId} has only {$available} items available."
            );
        }

        $this->availableStock[$productId] -= $quantity;
    }

    public function availableStock(int $productId): int
    {
        return $this->availableStock[$productId] ?? 0;
    }
}
