<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout;

use Override;
use Patterns\Facade\Checkout\Exception\ProductNotFound;
use Patterns\Facade\Checkout\Interface\PricingService;

final readonly class CatalogPricingSerice implements PricingService
{
    /**
     * @param array<int, int> $priceInCents
     * @param array<string, int> $couponDiscounts
     */
    public function __construct(
        private array $priceInCents,
        private array $couponDiscounts = []
    ) {}

    #[Override]
    public function calculateTotal(array $items, ?string $couponCode): int
    {
        $subTotal = 0;

        foreach ($items as $item) {
            if (!array_key_exists($item->productId, $this->priceInCents)) {
                throw new ProductNotFound(
                    "Product {$item->productId} was not found."
                );
            }

            $subTotal += $this->priceInCents[$item->productId] * $item->quantity;
        }

        if ($couponCode == null) {
            return $subTotal;
        }

        $normalizedCoupon = strtoupper(trim($couponCode));

        $discountPercentage = $this->couponDiscounts[$normalizedCoupon] ?? 0;

        $discount = intdiv(
            $subTotal * $discountPercentage,
            100
        );

        return $subTotal - $discount;
    }
}
